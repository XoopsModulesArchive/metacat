CREATE TABLE metacat_categories (
    cat_id        MEDIUMINT(9) NOT NULL AUTO_INCREMENT,
    parent_id     MEDIUMINT(9)          DEFAULT '0',
    title         VARCHAR(50)  NOT NULL DEFAULT '',
    description   TEXT,
    image         VARCHAR(150)          DEFAULT NULL,
    module_id     TEXT         NOT NULL,
    module_parent TEXT         NOT NULL,
    PRIMARY KEY (cat_id)
)
    ENGINE = ISAM
    AUTO_INCREMENT = 1;
