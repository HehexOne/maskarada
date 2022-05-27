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


INSERT INTO Products(name, image_path, description, price)
VALUES ('WellDerma Механический массажёр для лица Face Lifting Pad', 'static/data/well.png', 'Ручной массажер для контурного массажа лица, зоны декольте, ключиц и других участков тела.
Обеспечивает нормализацию кровообращения и расслабление напряженных мышц, способствует повышению упругости и эластичности кожи, помогает в борьбе с возрастными изменениями кожи. Уменьшает отечность и способствуют улучшению тона кожи за счет усиления притока крови.
Способ применения:
Используйте массажёр на сухой коже или делайте массаж по маслу, крему или сыворотке для лучшего скольжения. Двигайтесь по направлению массажных линий – от центра к периферии и/или снизу вверх. Продолжительность массажа не должна превышать 8-10 минут.',
        1990);

INSERT INTO Products(name, image_path, description, price)
VALUES ('FARMSTAY Гидрогелевые Патчи для Глаз  с Коллагеном / 60 шт / COLLAGEN Hydrogel EYE PATCH',
        'static/data/coll.png',
        'Гидрогелевые патчи c коллагеном пропитаны высококонцентрированной сывороткой, которая быстро снимает отечность и устраняет темные круги под глазами. Применение: лопаточкой достать патчи, разместить на коже у зоны вокруг глаз острым кончиком к переносице, добиться плотного прилегания. Через 20-30 минут снять. Идеально использовать утром.',
        1190);

INSERT INTO Products(name, image_path, description, price)
VALUES ('Elizavecca Маски для лица Power Ringer (12шт)', 'static/data/eliza.png', 'Набор тканевых масок Elizavecca включает в себя 12 самых популярных составов тканевых масок Elizavecca и состоит из следующих масок: 1. Маска с древесным углем. 2. Маска с чайным деревом. 3. Маска с фруктами. 4. Маска с витаминами. 5. Маска с коллагеном. 6. Маска АКВА. 7. Маска с молоком. 8. Маска с красным женьшенем. 9. Маска с гиалуроновой кислотой. 10. Маска с центеллой. 11. Маска с EGF. 12. Маска с медом.  Объем каждой маски: 23 мл.

Способ применения
Маску наносить на очищенное лицо. Маску аккуратно распределить по коже лица так, чтобы она равномерно и плотно прилегла к контуру лица. Снять маску через 20-30 минут. Остатки эссенции аккуратно и равномерно распределить по коже лица (подушечками пальцев) до полного впитывания.',
        720);

INSERT INTO Products(name, image_path, description, price)
VALUES ('Lador Шампунь для волос с аргановым маслом и коллагеном Damaged Protector Acid Shampoo, 150 мл',
        'static/data/lador.png', 'Профессиональный бесщелочной шампунь с аргановым маслом, с кислотным уровнем pH 4.5, рекомендован для сухих, ослабленных и поврежденных волос, превосходно увлажняет, питает и защищает волосы от потери влаги, вызванной негативным влиянием окружающей среды.
Восстанавливает кожу головы и волосяные луковицы, защищает от преждевременного выпадения волос, устраняет и предотвращает появление перхоти.
Практически не пенится, хорошо распутывает и разглаживает волосы. Сохраняет стойкость цвета и рекомендован даже для ежедневного применения для окрашенных волос.
Аргановое масло богато витамином Е и насыщенными жирными кислотами Омега Б, которые играют одну из основных ролей в восстановлении структуры волос.
Идеально подходит к использованию для волос, подвергавшихся воздействию химических препаратов.', 280);

INSERT INTO Products(name, image_path, description, price)
VALUES ('Lador Восстанавливающая маска для сухих и поврежденных волос с коллагеном и аминокислотным комплексом Hydro LPP Treatment 150 мл',
        'static/data/lador-hair.png',
        'Восстанавливающая маска Lador Hydro LPP Treatment в объеме 150 мл. предназначена для сухих и поврежденных волос. Оказывает укрепляющий эффект от корней до кончиков. В состав маски входит широкий ассортимент питательных веществ для здоровья кожи и волос. Средство содержит оптимальный баланс кислотности ph 5.5, улучшает состояние волос и кожи головы, уменьшает ломкость, предотвращает появления перхоти и секущихся кончиков. Благодаря коллагену и аминокислотному комплексу LPP волосы становятся более ровными, упругими, гладкими и блестящими.',
        380);
