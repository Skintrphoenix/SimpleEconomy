-- #!mysql
-- #{ init
CREATE TABLE IF NOT EXISTS economy (
    player VARCHAR(255) NOT NULL PRIMARY KEY,
    balance FLOAT(11) NOT NULL DEFAULT 0
);
-- #}
-- #{ load
-- #    :player string
SELECT * FROM economy
WHERE player = :player;
-- #}
-- #{ create
-- #    :player string
-- #    :balance float
INSERT INTO economy (player, balance)
VALUES (:player, :balance);
-- #}
-- #{ add
-- #    :player string
-- #    :balance float
UPDATE economy SET balance = balance + :balance
WHERE player = :player;
-- #}
-- #{ subtract
-- #    :player string
-- #    :balance float
UPDATE economy SET balance = balance - :balance
WHERE player = :player;
-- #}
-- #{ set
-- #    :player string
-- #    :balance float
UPDATE economy SET balance = :balance
WHERE player = :player;
-- #}
-- #{ get
-- #    :player string
SELECT * FROM economy
WHERE player = :player;
-- #}
-- #{ all
SELECT * FROM economy ORDER BY balance DESC;
-- #}
