CREATE TABLE login (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  Name TEXT NOT NULL,
  Email TEXT NOT NULL UNIQUE,
  Password TEXT NOT NULL,
  Accounttype TEXT NOT NULL CHECK(Accounttype IN ('startup', 'investor'))
);
CREATE TABLE sqlite_sequence(name,seq);
CREATE TABLE investor_portfolio (
  investor_id INTEGER,
  Agriculture FLOAT,
  Manufacturing FLOAT,
  InformationTechnology FLOAT,
  Pharmaceuticals FLOAT,
  Automobile FLOAT,
  FinancialServices FLOAT,
  Infrastructure FLOAT,
  TourismHospitality FLOAT,
  EducationTraining FLOAT,
  RetailEcommerce FLOAT,
  anyother FLOAT,
  FOREIGN KEY (investor_id) REFERENCES login(id)
);
CREATE TABLE information_investor (
  investor_id INTEGER PRIMARY KEY,
  location TEXT,
  currentrole TEXT,
  yourstory TEXT,
  experience TEXT,
  education TEXT,
  expertise TEXT, image TEXT, Funding_stage_preference TEXT,
  FOREIGN KEY (investor_id) REFERENCES login(id)
);
CREATE TABLE investor_interests (
  investor_id INTEGER,
  interested_field TEXT,
  FOREIGN KEY (investor_id) REFERENCES login(id),
  PRIMARY KEY (investor_id, interested_field)
);
CREATE TABLE chats (
  id INTEGER PRIMARY KEY,
  type TEXT CHECK(type IN ('twopeople', 'group')),
  timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE messages (
  chat_id INTEGER,
  person_id INTEGER,
  message TEXT,
  timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (chat_id) REFERENCES chats(id),
  FOREIGN KEY (person_id) REFERENCES login(id),
  PRIMARY KEY (chat_id, person_id, timestamp)
);
CREATE TABLE chat_twopeople (
  chat_id INTEGER,
  person1_id INTEGER,
  person2_id INTEGER,
  FOREIGN KEY (chat_id) REFERENCES chats(id),
  FOREIGN KEY (person1_id) REFERENCES login(id),
  FOREIGN KEY (person2_id) REFERENCES login(id),
  PRIMARY KEY (person1_id, person2_id)
);
CREATE TABLE chat_groupchat_info (
  chat_id INTEGER PRIMARY KEY,
  image BLOB,
  title TEXT,
  admin_id INTEGER,
  FOREIGN KEY (chat_id) REFERENCES chats(id),
  FOREIGN KEY (admin_id) REFERENCES login(id)
);
CREATE TABLE groupchat (
  chat_id INTEGER,
  person_id INTEGER,
  timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  role TEXT CHECK(role IN ('admin', 'member')),
  FOREIGN KEY (chat_id) REFERENCES chats(id),
  FOREIGN KEY (person_id) REFERENCES login(id),
  PRIMARY KEY (chat_id, person_id)
);
CREATE TABLE people_team_startups (
  id INTEGER PRIMARY KEY,
  startup_id INTEGER,
  Name TEXT,
  Role TEXT,
  Degree_uni TEXT,
  person_image_path TEXT,
  FOREIGN KEY (startup_id) REFERENCES "old_startups_info"(startup_id)
);
CREATE TABLE IF NOT EXISTS "old_startups_info" (
  startup_id INTEGER PRIMARY KEY,
  startup_name TEXT,
  industry TEXT,
  location TEXT,
  vision TEXT,
  usp TEXT,
  motivation TEXT,
  target_market TEXT,
  customer_num INTEGER,
  revenue_till_date INTEGER,
  Team_size INTEGER,
  Founding_year INTEGER,
  logo TEXT, -- Now a TEXT type
  Funding_stage TEXT,
  Customer_acc_cost INTEGER,
  Retention_rate_perc INTEGER,
  User_growth_perc INTEGER,
  FOREIGN KEY (startup_id) REFERENCES login(id)
);
CREATE TABLE startups_information (
startup_id INTEGER PRIMARY KEY,
startup_name TEXT,
industry TEXT,
location TEXT,
vision TEXT,
usp TEXT,
motivation TEXT,
target_market TEXT,
customer_num INTEGER,
revenue_till_date INTEGER,
Team_size INTEGER,
Founding_year INTEGER,
logo TEXT,
Funding_stage TEXT,
Customer_acc_cost INTEGER,
Retention_rate_perc INTEGER,
User_growth_perc INTEGER,
about_team TEXT,
FOREIGN KEY (startup_id) REFERENCES login(id)
);