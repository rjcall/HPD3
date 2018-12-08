
CREATE TABLE `items` (
  `item_id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) DEFAULT NULL,
  `photo` varchar(64),
  `description` varchar(64) DEFAULT NULL,
  `valuation` decimal(15,2) DEFAULT NULL,
  `method` varchar(64) DEFAULT NULL,
  `verified` tinyint(1) DEFAULT NULL,
  `creationDate` date DEFAULT NULL,
  PRIMARY KEY (`item_id`)
) ENGINE=InnoDB;

CREATE TABLE `owners` (
  `owner_id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `fname` varchar(64) DEFAULT NULL,
  `lname` varchar(64) DEFAULT NULL,
  `street1` varchar(64) DEFAULT NULL,
  `street2` varchar(64) DEFAULT NULL,
  `city` varchar(64) DEFAULT NULL,
  `state` char(2) DEFAULT NULL,
  `zip` varchar(9) DEFAULT NULL,
  `policy` varchar(10) DEFAULT NULL,
  `expiration` date DEFAULT NULL,
  PRIMARY KEY (`owner_id`)
) ENGINE=InnoDB;

CREATE TABLE `owner_items` (
  `owner_item_id` mediumint(12) NOT NULL AUTO_INCREMENT,
  `item_id` mediumint(12) NOT NULL,
  `owner_id` mediumint(12) NOT NULL,
  PRIMARY KEY (`owner_item_id`),
  KEY `owner_items_ibfk_1` (`owner_id`),
  KEY `owner_items_ibfk_2` (`item_id`),
  CONSTRAINT `owner_items_ibfk_1` FOREIGN KEY (`owner_id`) REFERENCES `owners` (`owner_id`) ON DELETE CASCADE,
  CONSTRAINT `owner_items_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `items` (`item_id`) ON DELETE CASCADE
) ENGINE=InnoDB;
