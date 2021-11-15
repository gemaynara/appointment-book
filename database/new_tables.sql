CREATE TABLE `plans`
(
    `id`         int(11) AUTO_INCREMENT NOT NULL,
    `name`       varchar(1000)                   DEFAULT NULL,
    `image`      varchar(250)                    DEFAULT NULL,
    `active`     tinyint                         DEFAULT 1,
    `created_at` datetime               NOT NULL DEFAULT current_timestamp(),
    `updated_at` datetime               NOT NULL DEFAULT current_timestamp(),
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;
# --------------------------------------------------

ALTER TABLE `setting`
    ADD COLUMN `flat_fee` decimal(11,2) DEFAULT NULL,
    ADD COLUMN `percent_fee` int(11) DEFAULT NULL;
# --------------------------------------------------

CREATE TABLE `type_services`
(
    `id`                int(11) AUTO_INCREMENT NOT NULL,
    `type`              varchar(15)                   DEFAULT NULL,
    `name`              varchar(1000)                   DEFAULT NULL,
    `description`       varchar(1000)                   DEFAULT NULL,
    `producer`          varchar(1000)                   DEFAULT NULL,
    `price`             decimal(11, 2)                  DEFAULT NULL,
    `displacement_rate` decimal(11, 2)                  DEFAULT NULL,
    `total`             decimal(11, 2)                  DEFAULT NULL,
    `created_at`        datetime               NOT NULL DEFAULT current_timestamp(),
    `updated_at`        datetime               NOT NULL DEFAULT current_timestamp(),
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;
