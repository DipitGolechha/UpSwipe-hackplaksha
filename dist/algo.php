<?php

class StartupProfile {
    public $startup_id;
    public $industry_focus;
    public $funding_stage;
    public $user_growth;
    public $revenue;
    public $customer_acquisition_cost;
    public $retention_rate;
    public $traction_score;

    public function __construct($startup_id, $industry_focus, $funding_stage, $user_growth, $revenue, $customer_acquisition_cost, $retention_rate) {
        $this->startup_id = $startup_id;
        $this->industry_focus = $industry_focus;
        $this->funding_stage = $funding_stage;
        $this->user_growth = $user_growth;
        $this->revenue = $revenue;
        $this->customer_acquisition_cost = $customer_acquisition_cost;
        $this->retention_rate = $retention_rate;
        $this->traction_score = $this->calculate_traction_score();
    }

    public function calculate_traction_score() {
        $user_growth_weight = 0.4;
        $revenue_weight = 0.3;
        $customer_acquisition_cost_weight = 0.2;
        $retention_rate_weight = 0.1;

        // Extract relevant data
        $data = [
            $this->user_growth,
            $this->revenue,
            $this->customer_acquisition_cost,
            $this->retention_rate
        ];

        // Calculate max and min values
        $max_value = max($data);
        $min_value = min($data);

        // Normalize values and calculate traction score
        $normalized_values = array_map(function($x) use ($min_value, $max_value) {
            return ($x - $min_value) / ($max_value - $min_value);
        }, $data);

        $traction_score = array_sum(array_map(function($w, $x) use ($user_growth_weight, $revenue_weight, $customer_acquisition_cost_weight, $retention_rate_weight) {
            return $w * $x;
        }, [$user_growth_weight, $revenue_weight, $customer_acquisition_cost_weight, $retention_rate_weight], $normalized_values));

        return $traction_score;
    }
}

function cosine_similarity($investor_preferences, $startup, $all_startups, $traction_weight) {
    $industry_similarity = $investor_preferences[0] == $startup->industry_focus ? 1 : 0;
    $funding_similarity = $investor_preferences[1] == $startup->funding_stage ? 1 : 0;

    // Normalization of traction score
    $max_traction_score = max(array_map(function($s) {
        return $s->traction_score;
    }, $all_startups));
    $min_traction_score = min(array_map(function($s) {
        return $s->traction_score;
    }, $all_startups));
    $traction_score_normalized = ($startup->traction_score - $min_traction_score) / ($max_traction_score - $min_traction_score);

    $traction_similarity = $traction_score_normalized * $traction_weight;

    return $industry_similarity + $funding_similarity + $traction_similarity;
}

function rank_potential_investments($investor_preferences, $all_startups, $traction_weight) {
    $similarity_scores = [];
    foreach ($all_startups as $startup) {
        $similarity = cosine_similarity($investor_preferences, $startup, $all_startups, $traction_weight);
        $similarity_scores[] = [$similarity, $startup];
    }
    usort($similarity_scores, function($a, $b) {
        return $b[0] <=> $a[0];
    });
    $ranked_investments = array_map(function($score) {
        return $score[1]->startup_id;
    }, $similarity_scores);
    $ranked_investments = array_pad($ranked_investments, 10, 0);
    return array_slice($ranked_investments, 0, 10);
}

function fill_preference_table($investor_interests, $startups, $conn) {
    $stmt = $conn->prepare("SELECT * FROM investor_interests");
    $stmt->execute();
    $interests = $stmt->fetchAll();

    $stmt = $conn->prepare("SELECT * FROM startups_grading_criteria");
    $stmt->execute();
    $all_startups = $stmt->fetchAll(PDO::FETCH_CLASS, "StartupProfile");

    $stmt = $conn->prepare("INSERT INTO investor_preferences (Investor_id, Pref_1, Pref_2, Pref_3, Pref_4, Pref_5, Pref_6, Pref_7, Pref_8, Pref_9, Pref_10) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
    foreach ($interests as $interest) {
        $investor_id = $interest['Investor_id'];
        $industry_focus = $interest['Interested_field'];
        $funding_stage = $interest['Preferred_funding_stage'];
        $investor_preferences = [$industry_focus, $funding_stage];
        $ranked_investments = rank_potential_investments($investor_preferences, $all_startups, 0.5);
        array_unshift($ranked_investments, $investor_id);
        $stmt->execute($ranked_investments);
    }
}

try {
    $conn = new PDO('sqlite:database.db');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $conn->exec('CREATE TABLE IF NOT EXISTS startups_grading_criteria (
        startup_id INTEGER PRIMARY KEY,
        Industry_focus TEXT NOT NULL,
        Funding_Stage TEXT NOT NULL,
        User_growth REAL NOT NULL,
        Revenue REAL NOT NULL,
        Customer_Acquisition_Cost REAL NOT NULL,
        Retention_rate REAL NOT NULL
    )');

    $conn->exec('CREATE TABLE IF NOT EXISTS investor_interests (
        Investor_id INTEGER PRIMARY KEY,
        Interested_field TEXT NOT NULL,
        Preferred_funding_stage TEXT NOT NULL
    )');

    $conn->exec('CREATE TABLE IF NOT EXISTS investor_preferences (
        Investor_id INTEGER,
        Pref_1 INTEGER NOT NULL,
        Pref_2 INTEGER NOT NULL,
        Pref_3 INTEGER NOT NULL,
        Pref_4 INTEGER NOT NULL,
        Pref_5 INTEGER NOT NULL,
        Pref_6 INTEGER NOT NULL,
        Pref_7 INTEGER NOT NULL,
        Pref_8 INTEGER NOT NULL,
        Pref_9 INTEGER NOT NULL,
        Pref_10 INTEGER NOT NULL,
        FOREIGN KEY (Investor_id) REFERENCES investor_interests(Investor_id)
    )');

    fill_preference_table($investor_interests, $startups, $conn);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>