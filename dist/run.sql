DELETE FROM login
WHERE Accounttype = 'investor'
AND NOT EXISTS (
    SELECT 1
    FROM information_investor
    WHERE information_investor.investor_id = login.id
);
