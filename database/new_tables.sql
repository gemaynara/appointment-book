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

CREATE TABLE `type_services`
(
    `id`                int(11) AUTO_INCREMENT NOT NULL,
    `type`              varchar(15)                     DEFAULT NULL,
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


# -------------------------------------------------------------------

CREATE TABLE `clinics`
(
    `id`                        int(11) AUTO_INCREMENT NOT NULL,
    `name`                      varchar(1000)                   DEFAULT NULL,
    `image`                     varchar(1000)                   DEFAULT NULL,
    `corporate_name`            varchar(1000)                   DEFAULT NULL,
    `cnpj`                      varchar(18)                     DEFAULT NULL,
    `email`                     varchar(1000)                   DEFAULT NULL,
    `phone`                     varchar(15)                     DEFAULT NULL,
    `contact_person`            varchar(1000)                   DEFAULT NULL,
    `agency`                    varchar(6)                      DEFAULT NULL,
    `account`                   varchar(20)                     DEFAULT NULL,
    `type_account`              varchar(20)                     DEFAULT NULL,
    `license_file`              varchar(1000)                   DEFAULT NULL,
    `license_expired_at`        date                            DEFAULT NULL,
    `license_health_file`       varchar(1000)                   DEFAULT NULL,
    `license_health_expired_at` date                            DEFAULT NULL,
    `services`                  varchar(1000)                   DEFAULT NULL,
    `created_at`                datetime               NOT NULL DEFAULT current_timestamp(),
    `updated_at`                datetime               NOT NULL DEFAULT current_timestamp(),
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

# ---------------------------------------
CREATE TABLE `permissions`
(
    `id`         int(11) AUTO_INCREMENT NOT NULL,
    `name`       varchar(1000)                   DEFAULT NULL,
    `permission` varchar(1000)                   DEFAULT NULL,
    `created_at` datetime               NOT NULL DEFAULT current_timestamp(),
    `updated_at` datetime               NOT NULL DEFAULT current_timestamp(),
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

