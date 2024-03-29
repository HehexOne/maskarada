# База многостраничного сайта

USE shop_db;

DROP EVENT IF EXISTS shop_db.StatusUpdater;
DROP EVENT IF EXISTS shop_db.CartChecker;
DROP TABLE IF EXISTS shop_db.UserCart, shop_db.ProductInCart, shop_db.ProductInOrder, shop_db.Orders, shop_db.OrderStatus, shop_db.Products, shop_db.Users;


CREATE TABLE shop_db.Users
(
    id                INTEGER UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    email             VARCHAR(64) UNIQUE NOT NULL,
    password_hash     VARCHAR(256)       NOT NULL,
    registration_date DATETIME DEFAULT NOW()
);

CREATE TABLE shop_db.Products
(
    id          INTEGER UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    name        VARCHAR(128)    NOT NULL,
    subtitle    VARCHAR(128)    NOT NULL,
    image_path  VARCHAR(512)    NOT NULL,
    description VARCHAR(1024)   NOT NULL,
    price       DOUBLE UNSIGNED NOT NULL
);

CREATE TABLE shop_db.OrderStatus
(
    id   INTEGER UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(32)
);

CREATE TABLE shop_db.Orders
(
    id               INTEGER UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    user_id          INTEGER UNSIGNED           NOT NULL,
    date             DATETIME         DEFAULT NOW(),
    receiver_name    VARCHAR(64)                NOT NULL,
    receiver_phone   VARCHAR(11)                NOT NULL,
    receiver_address VARCHAR(512)               NOT NULL,
    comments         VARCHAR(256)     DEFAULT '',
    status_id        INTEGER UNSIGNED DEFAULT 1 NOT NULL,
    FOREIGN KEY (user_id) REFERENCES shop_db.Users (id) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (status_id) REFERENCES shop_db.OrderStatus (id) ON UPDATE CASCADE
);

CREATE TABLE shop_db.ProductInOrder
(
    id         INTEGER UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    order_id   INTEGER UNSIGNED NOT NULL,
    product_id INTEGER UNSIGNED NOT NULL,
    quantity   INTEGER UNSIGNED NOT NULL,
    FOREIGN KEY (order_id) REFERENCES shop_db.Orders (id) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES shop_db.Products (id) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE shop_db.UserCart
(
    id            INTEGER UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    last_modified DATETIME DEFAULT NOW(),
    user_id       INTEGER UNSIGNED UNIQUE,
    FOREIGN KEY (user_id) REFERENCES shop_db.Users (id) ON UPDATE CASCADE ON DELETE CASCADE
);


CREATE TABLE shop_db.ProductInCart
(
    id         INTEGER UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    cart_id    INTEGER UNSIGNED,
    product_id INTEGER UNSIGNED,
    quantity   INTEGER UNSIGNED,
    FOREIGN KEY (cart_id) REFERENCES shop_db.UserCart (id) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES shop_db.Products (id) ON UPDATE CASCADE ON DELETE CASCADE
);


CREATE EVENT shop_db.StatusUpdater
    ON SCHEDULE EVERY 5 SECOND
        STARTS CURRENT_TIMESTAMP ENDS CURRENT_TIMESTAMP + INTERVAL 365 DAY
    DO
    UPDATE shop_db.Orders
    SET status_id = CASE
                        WHEN NOW() >= date + INTERVAL 90 SECOND THEN 4
                        WHEN NOW() >= date + INTERVAL 60 SECOND THEN 3
                        WHEN NOW() >= date + INTERVAL 30 SECOND THEN 2
                        ELSE 1 END;


CREATE EVENT shop_db.CartChecker
    ON SCHEDULE EVERY 5 SECOND
        STARTS CURRENT_TIMESTAMP ENDS CURRENT_TIMESTAMP + INTERVAL 365 DAY
    DO
    DELETE shop_db.ProductInCart
    FROM shop_db.ProductInCart
             INNER JOIN shop_db.UserCart UC on shop_db.ProductInCart.cart_id = UC.id
    WHERE EXTRACT(MINUTE FROM NOW() - last_modified) >= 30;


INSERT INTO shop_db.OrderStatus(id, name)
VALUES (1, 'Подтверждение заказа');
INSERT INTO shop_db.OrderStatus(id, name)
VALUES (2, 'Сборка заказа');
INSERT INTO shop_db.OrderStatus(id, name)
VALUES (3, 'Доставка заказа');
INSERT INTO shop_db.OrderStatus(id, name)
VALUES (4, 'Заказ доставлен');

INSERT INTO shop_db.Products(name, subtitle, image_path, description, price)
VALUES ('WellDerma Механический массажёр для лица Face Lifting Pad', 'Для контурного массажа', 'static/data/well.png', 'Ручной массажер для контурного массажа лица, зоны декольте, ключиц и других участков тела.
Обеспечивает нормализацию кровообращения и расслабление напряженных мышц, способствует повышению упругости и эластичности кожи, помогает в борьбе с возрастными изменениями кожи. Уменьшает отечность и способствуют улучшению тона кожи за счет усиления притока крови.
Способ применения:
Используйте массажёр на сухой коже или делайте массаж по маслу, крему или сыворотке для лучшего скольжения. Двигайтесь по направлению массажных линий – от центра к периферии и/или снизу вверх. Продолжительность массажа не должна превышать 8-10 минут.',
        1990);

INSERT INTO shop_db.Products(name, subtitle, image_path, description, price)
VALUES ('FARMSTAY Гидрогелевые Патчи для Глаз  с Коллагеном / 60 шт / COLLAGEN Hydrogel EYE PATCH',
        'Для снятия отёчности',
        'static/data/coll.png',
        'Гидрогелевые патчи c коллагеном пропитаны высококонцентрированной сывороткой, которая быстро снимает отечность и устраняет темные круги под глазами. Применение: лопаточкой достать патчи, разместить на коже у зоны вокруг глаз острым кончиком к переносице, добиться плотного прилегания. Через 20-30 минут снять. Идеально использовать утром.',
        1190);

INSERT INTO shop_db.Products(name, subtitle, image_path, description, price)
VALUES ('Elizavecca Маски для лица Power Ringer (12шт)', 'Набор питательных масок', 'static/data/eliza.png', 'Набор тканевых масок Elizavecca включает в себя 12 самых популярных составов тканевых масок Elizavecca и состоит из следующих масок: 1. Маска с древесным углем. 2. Маска с чайным деревом. 3. Маска с фруктами. 4. Маска с витаминами. 5. Маска с коллагеном. 6. Маска АКВА. 7. Маска с молоком. 8. Маска с красным женьшенем. 9. Маска с гиалуроновой кислотой. 10. Маска с центеллой. 11. Маска с EGF. 12. Маска с медом.  Объем каждой маски: 23 мл.

Способ применения
Маску наносить на очищенное лицо. Маску аккуратно распределить по коже лица так, чтобы она равномерно и плотно прилегла к контуру лица. Снять маску через 20-30 минут. Остатки эссенции аккуратно и равномерно распределить по коже лица (подушечками пальцев) до полного впитывания.',
        720);

INSERT INTO shop_db.Products(name, subtitle, image_path, description, price)
VALUES ('Lador Шампунь для волос с аргановым маслом и коллагеном Damaged Protector Acid Shampoo, 150 мл',
        'Для сухих и слабых волос',
        'static/data/lador.png', 'Профессиональный бесщелочной шампунь с аргановым маслом, с кислотным уровнем pH 4.5, рекомендован для сухих, ослабленных и поврежденных волос, превосходно увлажняет, питает и защищает волосы от потери влаги, вызванной негативным влиянием окружающей среды.
Восстанавливает кожу головы и волосяные луковицы, защищает от преждевременного выпадения волос, устраняет и предотвращает появление перхоти.
Практически не пенится, хорошо распутывает и разглаживает волосы. Сохраняет стойкость цвета и рекомендован даже для ежедневного применения для окрашенных волос.
Аргановое масло богато витамином Е и насыщенными жирными кислотами Омега Б, которые играют одну из основных ролей в восстановлении структуры волос.
Идеально подходит к использованию для волос, подвергавшихся воздействию химических препаратов.', 280);

INSERT INTO shop_db.Products(name, subtitle, image_path, description, price)
VALUES ('Lador Восстанавливающая маска волос с коллагеном и аминокислотным комплексом Hydro LPP Treatment 150 мл',
        'Для сухих и повреждённых волос',
        'static/data/lador-hair.png',
        'Восстанавливающая маска Lador Hydro LPP Treatment в объеме 150 мл. предназначена для сухих и поврежденных волос. Оказывает укрепляющий эффект от корней до кончиков. В состав маски входит широкий ассортимент питательных веществ для здоровья кожи и волос. Средство содержит оптимальный баланс кислотности ph 5.5, улучшает состояние волос и кожи головы, уменьшает ломкость, предотвращает появления перхоти и секущихся кончиков. Благодаря коллагену и аминокислотному комплексу LPP волосы становятся более ровными, упругими, гладкими и блестящими.',
        380);

INSERT INTO shop_db.Products(name, subtitle, image_path, description, price)
VALUES ('Пенка для умывания с коллагеном FarmStay Collagen Pure Cleansing Foam',
        'Увлажняющая и антивозрастная',
        'static/data/farm-stay.png',
        'Увлажняющая антивозрастная пенка на основе гидролизата коллагена отлично очищает кожу от остатков косметики, себума и загрязнений. Коллаген эффективно повышает упругость и эластичность кожи, выравнивает контур, стимулирует синтез собственного коллагена, увлажняет и препятствует потере влаги. Экстракт зеленого чая интенсивно увлажняет и тонизирует кожу, очищает поры, укрепляет стенки сосудов, оказывает активное антиоксидантное действие, выравнивает тон кожи и препятствует процессу старения. Масло оливы мгновенно восстанавливает сухую и увядающую кожу, питает и смягчает, увлажняет и препятствует обезвоживанию. Способ применения: небольшое количество средства вспенить с малым количеством воды и нанести массирующими движениями на кожу. Помассировать и тщательно смыть теплой водой.',
        350);

# ------------------------------------------------------------
# База лэндинг сайта

USE shop_db_landing;

DROP EVENT IF EXISTS shop_db_landing.StatusUpdater;
DROP TABLE IF EXISTS shop_db_landing.ProductInOrder, shop_db_landing.Products,
    shop_db_landing.Orders, shop_db_landing.OrderStatus;

CREATE TABLE shop_db_landing.OrderStatus
(
    id   INTEGER UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(128) NOT NULL
);

CREATE TABLE shop_db_landing.Orders
(
    id               INTEGER UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    date             DATETIME         DEFAULT NOW(),
    receiver_name    VARCHAR(64)                NOT NULL,
    receiver_phone   VARCHAR(11)                NOT NULL,
    receiver_address VARCHAR(512)               NOT NULL,
    comments         VARCHAR(256)     DEFAULT '',
    status_id        INTEGER UNSIGNED DEFAULT 1 NOT NULL,
    FOREIGN KEY (status_id) REFERENCES shop_db_landing.OrderStatus (id) ON UPDATE CASCADE
);

CREATE TABLE shop_db_landing.Products
(
    id          INTEGER UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    name        VARCHAR(128)    NOT NULL,
    subtitle    VARCHAR(128)    NOT NULL,
    image_path  VARCHAR(512)    NOT NULL,
    description VARCHAR(1024)   NOT NULL,
    price       DOUBLE UNSIGNED NOT NULL
);

CREATE TABLE shop_db_landing.ProductInOrder
(
    id         INTEGER UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    order_id   INTEGER UNSIGNED NOT NULL,
    product_id INTEGER UNSIGNED NOT NULL,
    quantity   INTEGER UNSIGNED NOT NULL,
    FOREIGN KEY (order_id) REFERENCES shop_db_landing.Orders (id) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES shop_db_landing.Products (id) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE EVENT shop_db_landing.StatusUpdater
    ON SCHEDULE EVERY 5 SECOND
        STARTS CURRENT_TIMESTAMP ENDS CURRENT_TIMESTAMP + INTERVAL 365 DAY
    DO
    UPDATE shop_db_landing.Orders
    SET status_id = CASE
                        WHEN NOW() >= date + INTERVAL 90 SECOND THEN 4
                        WHEN NOW() >= date + INTERVAL 60 SECOND THEN 3
                        WHEN NOW() >= date + INTERVAL 30 SECOND THEN 2
                        ELSE 1 END;


INSERT INTO shop_db_landing.OrderStatus(id, name)
VALUES (1, 'Подтверждение заказа');
INSERT INTO shop_db_landing.OrderStatus(id, name)
VALUES (2, 'Сборка заказа');
INSERT INTO shop_db_landing.OrderStatus(id, name)
VALUES (3, 'Доставка заказа');
INSERT INTO shop_db_landing.OrderStatus(id, name)
VALUES (4, 'Заказ доставлен');

INSERT INTO shop_db_landing.Products(name, subtitle, image_path, description, price)
VALUES ('WellDerma Механический массажёр для лица Face Lifting Pad', 'Для контурного массажа', 'static/data/well.png', 'Ручной массажер для контурного массажа лица, зоны декольте, ключиц и других участков тела.
Обеспечивает нормализацию кровообращения и расслабление напряженных мышц, способствует повышению упругости и эластичности кожи, помогает в борьбе с возрастными изменениями кожи. Уменьшает отечность и способствуют улучшению тона кожи за счет усиления притока крови.
Способ применения:
Используйте массажёр на сухой коже или делайте массаж по маслу, крему или сыворотке для лучшего скольжения. Двигайтесь по направлению массажных линий – от центра к периферии и/или снизу вверх. Продолжительность массажа не должна превышать 8-10 минут.',
        1990);

INSERT INTO shop_db_landing.Products(name, subtitle, image_path, description, price)
VALUES ('FARMSTAY Гидрогелевые Патчи для Глаз  с Коллагеном / 60 шт / COLLAGEN Hydrogel EYE PATCH',
        'Для снятия отёчности',
        'static/data/coll.png',
        'Гидрогелевые патчи c коллагеном пропитаны высококонцентрированной сывороткой, которая быстро снимает отечность и устраняет темные круги под глазами. Применение: лопаточкой достать патчи, разместить на коже у зоны вокруг глаз острым кончиком к переносице, добиться плотного прилегания. Через 20-30 минут снять. Идеально использовать утром.',
        1190);

INSERT INTO shop_db_landing.Products(name, subtitle, image_path, description, price)
VALUES ('Elizavecca Маски для лица Power Ringer (12шт)', 'Набор питательных масок', 'static/data/eliza.png', 'Набор тканевых масок Elizavecca включает в себя 12 самых популярных составов тканевых масок Elizavecca и состоит из следующих масок: 1. Маска с древесным углем. 2. Маска с чайным деревом. 3. Маска с фруктами. 4. Маска с витаминами. 5. Маска с коллагеном. 6. Маска АКВА. 7. Маска с молоком. 8. Маска с красным женьшенем. 9. Маска с гиалуроновой кислотой. 10. Маска с центеллой. 11. Маска с EGF. 12. Маска с медом.  Объем каждой маски: 23 мл.

Способ применения
Маску наносить на очищенное лицо. Маску аккуратно распределить по коже лица так, чтобы она равномерно и плотно прилегла к контуру лица. Снять маску через 20-30 минут. Остатки эссенции аккуратно и равномерно распределить по коже лица (подушечками пальцев) до полного впитывания.',
        720);

INSERT INTO shop_db_landing.Products(name, subtitle, image_path, description, price)
VALUES ('Lador Шампунь для волос с аргановым маслом и коллагеном Damaged Protector Acid Shampoo, 150 мл',
        'Для сухих и слабых волос',
        'static/data/lador.png', 'Профессиональный бесщелочной шампунь с аргановым маслом, с кислотным уровнем pH 4.5, рекомендован для сухих, ослабленных и поврежденных волос, превосходно увлажняет, питает и защищает волосы от потери влаги, вызванной негативным влиянием окружающей среды.
Восстанавливает кожу головы и волосяные луковицы, защищает от преждевременного выпадения волос, устраняет и предотвращает появление перхоти.
Практически не пенится, хорошо распутывает и разглаживает волосы. Сохраняет стойкость цвета и рекомендован даже для ежедневного применения для окрашенных волос.
Аргановое масло богато витамином Е и насыщенными жирными кислотами Омега Б, которые играют одну из основных ролей в восстановлении структуры волос.
Идеально подходит к использованию для волос, подвергавшихся воздействию химических препаратов.', 280);

INSERT INTO shop_db_landing.Products(name, subtitle, image_path, description, price)
VALUES ('Lador Восстанавливающая маска волос с коллагеном и аминокислотным комплексом Hydro LPP Treatment 150 мл',
        'Для сухих и повреждённых волос',
        'static/data/lador-hair.png',
        'Восстанавливающая маска Lador Hydro LPP Treatment в объеме 150 мл. предназначена для сухих и поврежденных волос. Оказывает укрепляющий эффект от корней до кончиков. В состав маски входит широкий ассортимент питательных веществ для здоровья кожи и волос. Средство содержит оптимальный баланс кислотности ph 5.5, улучшает состояние волос и кожи головы, уменьшает ломкость, предотвращает появления перхоти и секущихся кончиков. Благодаря коллагену и аминокислотному комплексу LPP волосы становятся более ровными, упругими, гладкими и блестящими.',
        380);

INSERT INTO shop_db_landing.Products(name, subtitle, image_path, description, price)
VALUES ('Пенка для умывания с коллагеном FarmStay Collagen Pure Cleansing Foam',
        'Увлажняющая и антивозрастная',
        'static/data/farm-stay.png',
        'Увлажняющая антивозрастная пенка на основе гидролизата коллагена отлично очищает кожу от остатков косметики, себума и загрязнений. Коллаген эффективно повышает упругость и эластичность кожи, выравнивает контур, стимулирует синтез собственного коллагена, увлажняет и препятствует потере влаги. Экстракт зеленого чая интенсивно увлажняет и тонизирует кожу, очищает поры, укрепляет стенки сосудов, оказывает активное антиоксидантное действие, выравнивает тон кожи и препятствует процессу старения. Масло оливы мгновенно восстанавливает сухую и увядающую кожу, питает и смягчает, увлажняет и препятствует обезвоживанию. Способ применения: небольшое количество средства вспенить с малым количеством воды и нанести массирующими движениями на кожу. Помассировать и тщательно смыть теплой водой.',
        350);
