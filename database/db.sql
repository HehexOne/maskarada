USE shop_db;

DROP EVENT IF EXISTS StatusUpdater;
DROP TABLE IF EXISTS ProductInOrder, Orders, Products, Users;


CREATE TABLE Users
(
    id                INTEGER UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    email             VARCHAR(64) UNIQUE NOT NULL,
    password_hash     VARCHAR(256)       NOT NULL,
    registration_date DATETIME DEFAULT NOW()
);

CREATE TABLE Products
(
    id          INTEGER UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    name        VARCHAR(128)    NOT NULL,
    image_path  VARCHAR(512)    NOT NULL,
    description VARCHAR(1024)   NOT NULL,
    price       DOUBLE UNSIGNED NOT NULL
);

CREATE TABLE Orders
(
    id               INTEGER UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    user_id          INTEGER UNSIGNED           NOT NULL,
    date             DATETIME         DEFAULT NOW(),
    receiver_name    VARCHAR(64)                NOT NULL,
    receiver_phone   VARCHAR(11)                NOT NULL,
    receiver_address VARCHAR(512)               NOT NULL,
    comments         VARCHAR(256)     DEFAULT '',
    status           INTEGER UNSIGNED DEFAULT 0 NOT NULL,
    FOREIGN KEY (user_id) REFERENCES Users (id) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE ProductInOrder
(
    id         INTEGER UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    order_id   INTEGER UNSIGNED NOT NULL,
    product_id INTEGER UNSIGNED NOT NULL,
    quantity   INTEGER UNSIGNED NOT NULL,
    FOREIGN KEY (order_id) REFERENCES Orders (id) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES Products (id) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE EVENT StatusUpdater
    ON SCHEDULE EVERY 5 SECOND
        STARTS CURRENT_TIMESTAMP ENDS CURRENT_TIMESTAMP + INTERVAL 365 DAY
    DO
    UPDATE Orders
    SET status = CASE
                     WHEN EXTRACT(MINUTE FROM NOW() - date) >= 3 THEN 3
                     WHEN EXTRACT(MINUTE FROM NOW() - date) >= 2 THEN 2
                     WHEN EXTRACT(MINUTE FROM NOW() - date) >= 1 THEN 1
                     ELSE 0 END;
