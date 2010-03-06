-- File: install.sql
-- Installation SQL routine for component JResearch
-- Author: Luis Galarraga
-- Date: 27-05-2008 00:14:00

DROP TABLE IF EXISTS `#__jresearch_article`;
CREATE TABLE IF NOT EXISTS `#__jresearch_article` (
  `id_publication` int(11) NOT NULL,
  `journal` varchar(255) NOT NULL,
  `volume` varchar(30) default NULL,
  `number` varchar(10) default NULL,
  `pages` varchar(20) default NULL,
  `month` varchar(20) default NULL,
  `crossref` varchar(255) default NULL,
  PRIMARY KEY  (`id_publication`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `#__jresearch_recava_article`;
CREATE TABLE IF NOT EXISTS `#__jresearch_recava_article` (
  `id_publication` int(11) NOT NULL,
  `journal` varchar(255) NOT NULL,
  `volume` varchar(30) default NULL,
  `number` varchar(10) default NULL,
  `pages` varchar(20) default NULL,
  `recava_ack` bool default false,
  `other_recava_groups` bool default false,
  `recava_groups` varchar(500) default NULL,
  `used_recava_platforms` bool default false,
  `recava_platforms` varchar(500) default NULL,	
  `priority_line` varchar(255) default NULL,
  `secondary_lines` varchar(255) default 'C1=0;C2=0;C3=0;C4=0;C5=0;C6=0;C7=0;C8=0;C9=0;C10=0;C11=0',
  `id_journal` int(11) default NULL,
  PRIMARY KEY  (`id_publication`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `#__jresearch_book`;
CREATE TABLE IF NOT EXISTS `#__jresearch_book` (
  `id_publication` int(10) unsigned NOT NULL,
  `publisher` varchar(60) NOT NULL,
  `editor` varchar(255) NOT NULL,
  `volume` varchar(30) default NULL,
  `number` varchar(20) default NULL,
  `series` varchar(255) default NULL,
  `address` varchar(255) default NULL,
  `edition` varchar(10) default NULL,
  `month` varchar(20) default NULL,
  PRIMARY KEY  (`id_publication`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `#__jresearch_booklet`;
CREATE TABLE IF NOT EXISTS `#__jresearch_booklet` (
  `id_publication` int(10) unsigned NOT NULL,
  `howpublished` varchar(255) default NULL,
  `address` varchar(255) default NULL,
  `month` varchar(20) default NULL,
  PRIMARY KEY  (`id_publication`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `#__jresearch_citing_style`;
CREATE TABLE IF NOT EXISTS `#__jresearch_citing_style` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(20) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


DROP TABLE IF EXISTS `#__jresearch_conference`;
CREATE TABLE IF NOT EXISTS `#__jresearch_conference` (
  `id_publication` int(10) unsigned NOT NULL,
  `editor` varchar(255) default NULL,
  `volume` varchar(30) default NULL,
  `booktitle` varchar(255) default NULL,
  `number` varchar(10) default NULL,
  `series` varchar(255) default NULL,
  `pages` varchar(20) default NULL,
  `address` varchar(255) default NULL,
  `month` varchar(20) default NULL,
  `publisher` varchar(60) default NULL,
  `organization` varchar(255) default NULL,
  `crossref` varchar(255) default NULL,
  PRIMARY KEY  (`id_publication`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `#__jresearch_course`;
CREATE TABLE IF NOT EXISTS `#__jresearch_course` (
	`id` int(10) unsigned NOT NULL auto_increment,
	`title` varchar(60) NOT NULL,
	`place` varchar(60) NOT NULL,
	`start_date` datetime NOT NULL,
	`end_date` datetime NOT NULL,
	`participants` ENUM('<50','50-100','>100'),
	`published` tinyint(4) NOT NULL default '1',
	`checked_out` tinyint(11) unsigned NOT NULL default '0',
  	`checked_out_time` datetime NOT NULL,
  	`created` datetime NULL,
	`created_by` int(10) default NULL,
  	PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `#__jresearch_course_external_author`;
CREATE TABLE IF NOT EXISTS `#__jresearch_course_external_author` (
	`id_course` int(10) unsigned NOT NULL auto_increment,
	`author_name` varchar(60) NOT NULL,
	`order` smallint(5) unsigned NOT NULL,
  	PRIMARY KEY (`id_course`, `author_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `#__jresearch_course_internal_author`;
CREATE TABLE IF NOT EXISTS `#__jresearch_course_internal_author` (
	`id_course` int(10) unsigned NOT NULL,
	`id_staff_member` int(10) unsigned NOT NULL,
	`order` smallint(5) unsigned NOT NULL,
  	PRIMARY KEY (`id_course`, `id_staff_member`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `#__jresearch_financier`;
CREATE TABLE IF NOT EXISTS `#__jresearch_financier` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `name` varchar(60) NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `published` tinyint(4) NOT NULL default '1',
  `checked_out` tinyint(11) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `#__jresearch_inbook`;
CREATE TABLE IF NOT EXISTS `#__jresearch_inbook` (
  `id_publication` int(10) unsigned NOT NULL,
  `editor` varchar(255) default NULL,
  `chapter` varchar(10) default NULL,
  `pages` varchar(20) default NULL,
  `publisher` varchar(60) NOT NULL,
  `volume` varchar(30) default NULL,
  `number` varchar(10) default NULL,
  `series` varchar(255) default NULL,
  `type` varchar(20) default NULL,
  `address` varchar(255) default NULL,
  `edition` varchar(10) default NULL,
  `month` varchar(20) default NULL,
  PRIMARY KEY  (`id_publication`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `#__jresearch_incollection`;
CREATE TABLE IF NOT EXISTS `#__jresearch_incollection` (
  `id_publication` int(11) NOT NULL,
  `booktitle` varchar(255) NOT NULL,
  `publisher` varchar(60) NOT NULL,
  `editor` varchar(255) default NULL,
  `organization` varchar(255) default NULL,
  `address` varchar(255) default NULL,
  `pages` varchar(20) default NULL,
  `month` varchar(20) default NULL,
  `key` varchar(255) default NULL,
  `crossref` varchar(255) default NULL,
  PRIMARY KEY  (`id_publication`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `#__jresearch_manual`;
CREATE TABLE IF NOT EXISTS `#__jresearch_manual` (
  `id_publication` int(10) unsigned NOT NULL,
  `organization` varchar(255) default NULL,
  `address` varchar(255) default NULL,
  `edition` varchar(10) default NULL,
  `month` varchar(20) default NULL,
  PRIMARY KEY  (`id_publication`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `#__jresearch_mastersthesis`;
CREATE TABLE IF NOT EXISTS `#__jresearch_mastersthesis` (
  `id_publication` int(10) unsigned NOT NULL,
  `school` varchar(255) NOT NULL,
  `type` varchar(20) default NULL,
  `address` varchar(255) default NULL,
  `month` varchar(20) default NULL,
  PRIMARY KEY  (`id_publication`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `#__jresearch_misc`;
CREATE TABLE IF NOT EXISTS `#__jresearch_misc` (
  `id_publication` int(10) unsigned NOT NULL,
  `howpublished` varchar(255) default NULL,
  `month` varchar(20) default NULL,
  PRIMARY KEY  (`id_publication`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `#__jresearch_patent`;
CREATE TABLE IF NOT EXISTS `#__jresearch_patent` (
  `id_publication` int(10) unsigned NOT NULL,
  `patent_number` varchar(10) NOT NULL,
  `issue_date` date DEFAULT NULL,
  `titular_entity` varchar(255) DEFAULT NULL,
  `extended_countries` varchar(255) DEFAULT NULL,
  `in_explotation` bool DEFAULT false,
  `country` varchar(60) DEFAULT NULL,
  PRIMARY KEY  (`id_publication`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `#__jresearch_patent_external_inventor`;
CREATE TABLE IF NOT EXISTS `#__jresearch_patent_external_inventor` (
  `id_patent` int(10) unsigned NOT NULL,
  `author_name` varchar(60) NOT NULL,
  `order` smallint(5) unsigned NOT NULL,
  PRIMARY KEY  (`id_patent`,`author_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `#__jresearch_patent_internal_inventor`;
CREATE TABLE IF NOT EXISTS `#__jresearch_patent_internal_inventor` (
  `id_patent` int(10) unsigned NOT NULL,
  `id_staff_member` int(10) unsigned NOT NULL,
  `order` smallint(5) unsigned NOT NULL,
  PRIMARY KEY  (`id_patent`,`id_staff_member`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `#__jresearch_patent_team`;
CREATE TABLE IF NOT EXISTS `#__jresearch_patent_team` (
  `id_patent` int(10) unsigned NOT NULL,
  `id_team` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`id_patent`,`id_team`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `#__jresearch_phdthesis`;
CREATE TABLE IF NOT EXISTS `#__jresearch_phdthesis` (
  `id_publication` int(10) unsigned NOT NULL,
  `school` varchar(255) NOT NULL,
  `type` varchar(20) default NULL,
  `address` varchar(255) default NULL,
  `month` varchar(20) default NULL,
  PRIMARY KEY  (`id_publication`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `#__jresearch_proceedings`;
CREATE TABLE IF NOT EXISTS `#__jresearch_proceedings` (
  `id_publication` int(10) unsigned NOT NULL,
  `editor` varchar(255) default NULL,
  `volume` varchar(30) default NULL,
  `number` varchar(10) default NULL,
  `series` varchar(255) default NULL,
  `address` varchar(255) default NULL,
  `month` varchar(20) default NULL,
  `publisher` varchar(60) default NULL,
  `organization` varchar(255) default NULL,
  PRIMARY KEY  (`id_publication`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `#__jresearch_project`;
CREATE TABLE IF NOT EXISTS `#__jresearch_project` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `title` varchar(255) NOT NULL,
  `id_research_area` int(10) unsigned NOT NULL default '1',
  `published` tinyint(4) NOT NULL default '1',
  `url` varchar(255) default NULL,
  `status` enum('not_started','in_progress','finished') NOT NULL default 'not_started',
  `start_date` date default NULL,
  `end_date` date default NULL,
  `url_project_image` varchar(255) default NULL,
  `description` text,
  `finance_value` decimal(12,2) default NULL,
  `finance_currency` varchar(5) default NULL,
  `checked_out` tinyint(11) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL,
  `created` datetime NULL,
  `created_by` int(10) default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `title` (`title`),
  INDEX `id_research_area` (`id_research_area`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

DROP TABLE IF EXISTS `#__jresearch_project_external_author`;
CREATE TABLE IF NOT EXISTS `#__jresearch_project_external_author` (
  `id_project` int(10) unsigned NOT NULL,
  `author_name` varchar(60) NOT NULL,
  `is_principal` tinyint(4) NOT NULL default '0',
  `order` smallint(5) unsigned NOT NULL,
  PRIMARY KEY  (`id_project`,`author_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `#__jresearch_project_financier`;
CREATE TABLE IF NOT EXISTS `#__jresearch_project_financier` (
  `id_project` int(10) unsigned NOT NULL,
  `id_financier` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`id_project`,`id_financier`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `#__jresearch_project_internal_author`;
CREATE TABLE IF NOT EXISTS `#__jresearch_project_internal_author` (
  `id_project` int(10) unsigned NOT NULL,
  `id_staff_member` int(10) unsigned NOT NULL,
  `is_principal` tinyint(4) NOT NULL default '0',
  `order` smallint(5) unsigned NOT NULL,
  PRIMARY KEY  (`id_project`,`id_staff_member`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `#__jresearch_publication`;
CREATE TABLE IF NOT EXISTS `#__jresearch_publication` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `id_research_area` int(10) unsigned NOT NULL default '1',
  `comments` text,
  `impact_factor` float unsigned default NULL,
  `pubtype` varchar(20) NOT NULL default 'book',
  `url` varchar(255) default NULL,
  `published` tinyint(4) NOT NULL default '1' ,
  `title` varchar(255) NOT NULL,
  `year` year(4) NULL,	
  `citekey` varchar(255) NOT NULL,
  `abstract` text,
  `internal` tinyint(4) NOT NULL default '1',
  `keywords` varchar(255) default NULL,
  `checked_out` tinyint(11) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL,
  `created` datetime NULL,
  `created_by` int(10) default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `citekey` (`citekey`),
  INDEX `year` (`year`),
  INDEX `pubtype` (`pubtype`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `#__jresearch_publication_comment`;
CREATE TABLE IF NOT EXISTS `#__jresearch_publication_comment` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `id_publication` int(10) unsigned NOT NULL,
  `subject` varchar(255) default NULL,
  `content` text NOT NULL,
  `datetime` datetime NOT NULL,
  `author` varchar(60) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `#__jresearch_publication_config_custom_citing_style`;
CREATE TABLE IF NOT EXISTS `#__jresearch_publication_config_custom_citing_style` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `publication_type` varchar(20) NOT NULL,
  `cite_format` text,
  `complete_reference_format` text,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `publication_type` (`publication_type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `#__jresearch_publication_external_author`;
CREATE TABLE IF NOT EXISTS `#__jresearch_publication_external_author` (
  `id_publication` int(10) unsigned NOT NULL,
  `author_name` varchar(60) NOT NULL,
  `order` smallint(5) unsigned NOT NULL,
  PRIMARY KEY  (`id_publication`,`author_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `#__jresearch_publication_internal_author`;
CREATE TABLE IF NOT EXISTS `#__jresearch_publication_internal_author` (
  `id_publication` int(10) unsigned NOT NULL,
  `id_staff_member` int(10) unsigned NOT NULL,
  `order` smallint(6) NOT NULL,
  PRIMARY KEY  (`id_publication`,`id_staff_member`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `#__jresearch_research_area`;
CREATE TABLE IF NOT EXISTS `#__jresearch_research_area` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `description` text,
  `published` tinyint(4) NOT NULL default '1',
  `checked_out` tinyint(11) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `#__jresearch_member`;
CREATE TABLE IF NOT EXISTS `#__jresearch_member` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `former_member` tinyint(1) NOT NULL,
  `firstname` varchar(30) NOT NULL,
  `lastname` varchar(30) NOT NULL,
  `email` varchar(255) NULL,
  `username` varchar(150) NOT NULL,
  `id_research_area` int(10) unsigned NOT NULL default '1',
  `position` varchar(30) default NULL,
  `url_personal_page` varchar(255) default NULL,
  `published` tinyint(4) NOT NULL default '1',
  `ordering` int(11) unsigned NOT NULL default '0',
  `phone_or_fax` varchar(15) default NULL,
  `url_photo` varchar(255) default NULL,
  `description` text,
  `checked_out` tinyint(11) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL,
  PRIMARY KEY  (`id`),
  INDEX `name` (`lastname`,`firstname`),
  INDEX `id_research_area` (`id_research_area`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `#__jresearch_techreport`;
CREATE TABLE IF NOT EXISTS `#__jresearch_techreport` (
  `id_publication` int(10) unsigned NOT NULL,
  `institution` varchar(255) NOT NULL,
  `type` varchar(20) default NULL,
  `number` varchar(10) default NULL,
  `address` varchar(255) default NULL,
  `month` varchar(20) default NULL,
  PRIMARY KEY  (`id_publication`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `#__jresearch_team`;
CREATE TABLE IF NOT EXISTS `#__jresearch_team` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `id_leader` int(11) unsigned NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text,
  `published` tinyint(4) NOT NULL default '0',
  `checked_out` tinyint(11) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL,
  PRIMARY KEY  (`id`),
  FULLTEXT KEY `description` (`description`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

DROP TABLE IF EXISTS `#__jresearch_team_member`;
CREATE TABLE IF NOT EXISTS `#__jresearch_team_member` (
  `id_team` int(11) unsigned NOT NULL auto_increment,
  `id_member` int(11) unsigned NOT NULL,
  PRIMARY KEY  (`id_team`, `id_member`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `#__jresearch_thesis`;
CREATE TABLE IF NOT EXISTS `#__jresearch_thesis` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `title` varchar(255) NOT NULL,
  `id_research_area` int(10) unsigned NOT NULL default '1',
  `degree` enum('bachelor','master','phd') NOT NULL default 'bachelor',
  `status` enum('not_started','in_progress','finished') NOT NULL default 'not_started',
  `start_date` date default NULL,
  `end_date` date default NULL,
  `published` tinyint(4) NOT NULL default '1',
  `description` text,
  `url` varchar(255) default NULL,
  `checked_out` tinyint(11) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL,
  `created` datetime NULL,
  `created_by` int(10) default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `title` (`title`),
  INDEX `id_research_area` (`id_research_area`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `#__jresearch_thesis_external_author`;
CREATE TABLE IF NOT EXISTS `#__jresearch_thesis_external_author` (
  `id_thesis` int(10) unsigned NOT NULL,
  `author_name` varchar(60) NOT NULL,
  `order` smallint(5) unsigned NOT NULL,
  `is_director` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`id_thesis`,`author_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `#__jresearch_thesis_internal_author`;
CREATE TABLE IF NOT EXISTS `#__jresearch_thesis_internal_author` (
  `id_thesis` int(10) unsigned NOT NULL,
  `id_staff_member` int(10) unsigned NOT NULL,
  `order` smallint(5) unsigned NOT NULL,
  `is_director` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`id_thesis`,`id_staff_member`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `#__jresearch_unpublished`;
CREATE TABLE IF NOT EXISTS `#__jresearch_unpublished` (
  `id_publication` int(10) unsigned NOT NULL,
  `month` varchar(20) default NULL,
  PRIMARY KEY  (`id_publication`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `#__jresearch_cited_records`;
CREATE TABLE `#__jresearch_cited_records` (
	`id_record` INT UNSIGNED NOT NULL ,
	`record_type` VARCHAR( 60 ) NOT NULL ,
	`citekey` VARCHAR( 255 ) NOT NULL ,
	PRIMARY KEY ( `id_record` , `record_type`, `citekey` )
) ENGINE = MYISAM DEFAULT CHARSET=utf8; 

DROP TABLE IF EXISTS `#__jresearch_property`;
CREATE TABLE `#__jresearch_property` (
	`name` VARCHAR( 40 ) NOT NULL ,
	PRIMARY KEY ( `name` )
) ENGINE = MYISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `#__jresearch_cooperations`;
CREATE TABLE IF NOT EXISTS `#__jresearch_cooperations` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `name` varchar(100) NOT NULL,
  `image_url` varchar(256) DEFAULT NULL,
  `description` tinytext NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `published` tinyint(4) NOT NULL default '0',
  `ordering` int(11) unsigned NOT NULL default '0',
  `checked_out` tinyint(11) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL,
  PRIMARY KEY  (`id`),
  FULLTEXT KEY `description` (`description`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

DROP TABLE IF EXISTS `#__jresearch_facilities`;
CREATE TABLE IF NOT EXISTS `#__jresearch_facilities` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `id_research_area` int(10) unsigned NOT NULL default '1',
  `name` varchar(50) NOT NULL,
  `image_url` varchar(256) DEFAULT NULL,
  `description` tinytext NOT NULL,
  `published` tinyint(4) NOT NULL default '0',
  `ordering` int(11) unsigned NOT NULL default '0',
  `checked_out` tinyint(11) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL,
  PRIMARY KEY  (`id`),
  FULLTEXT KEY `description` (`description`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

DROP TABLE IF EXISTS `#__jresearch_journals`;
CREATE TABLE IF NOT EXISTS `#__jresearch_journals` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `title` varchar(255) NOT NULL,
  `published` tinyint(4) NOT NULL default '0',
  `impact_factor` int(11) NOT NULL default '0',
  `checked_out` tinyint(11) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;




INSERT INTO `#__jresearch_property` (`name`) VALUES ('abstract');
INSERT INTO `#__jresearch_property` (`name`) VALUES ('address');
INSERT INTO `#__jresearch_property` (`name`) VALUES ('annote');
INSERT INTO `#__jresearch_property` (`name`) VALUES ('author');
INSERT INTO `#__jresearch_property` (`name`) VALUES ('booktitle');
INSERT INTO `#__jresearch_property` (`name`) VALUES ('chapter');
INSERT INTO `#__jresearch_property` (`name`) VALUES ('crossref');
INSERT INTO `#__jresearch_property` (`name`) VALUES ('edition');
INSERT INTO `#__jresearch_property` (`name`) VALUES ('editor');
INSERT INTO `#__jresearch_property` (`name`) VALUES ('howpublished');
INSERT INTO `#__jresearch_property` (`name`) VALUES ('institution');
INSERT INTO `#__jresearch_property` (`name`) VALUES ('journal');
INSERT INTO `#__jresearch_property` (`name`) VALUES ('key');
INSERT INTO `#__jresearch_property` (`name`) VALUES ('month');
INSERT INTO `#__jresearch_property` (`name`) VALUES ('note');
INSERT INTO `#__jresearch_property` (`name`) VALUES ('number');
INSERT INTO `#__jresearch_property` (`name`) VALUES ('organization');
INSERT INTO `#__jresearch_property` (`name`) VALUES ('pages');
INSERT INTO `#__jresearch_property` (`name`) VALUES ('publisher');
INSERT INTO `#__jresearch_property` (`name`) VALUES ('school');
INSERT INTO `#__jresearch_property` (`name`) VALUES ('series');
INSERT INTO `#__jresearch_property` (`name`) VALUES ('title');
INSERT INTO `#__jresearch_property` (`name`) VALUES ('type');
INSERT INTO `#__jresearch_property` (`name`) VALUES ('url');
INSERT INTO `#__jresearch_property` (`name`) VALUES ('volume');
INSERT INTO `#__jresearch_property` (`name`) VALUES ('year');
INSERT INTO `#__jresearch_property` (`name`) VALUES ('keywords');

-- Include in upgrade patch
INSERT INTO `#__jresearch_property` (`name`) VALUES ('journal_acceptance_rate');
INSERT INTO `#__jresearch_property` (`name`) VALUES ('impact_factor');
INSERT INTO `#__jresearch_property` (`name`) VALUES ('awards');
INSERT INTO `#__jresearch_property` (`name`) VALUES ('comments');

DROP TABLE IF EXISTS `#__jresearch_publication_type`;
CREATE TABLE `#__jresearch_publication_type` (
	`name` VARCHAR( 20 ) NOT NULL,
	PRIMARY KEY (`name`)
) ENGINE = MYISAM DEFAULT CHARSET=utf8; 

CREATE OR REPLACE VIEW `#__jresearch_publication_article` AS SELECT * FROM `#__jresearch_article` JOIN `#__jresearch_publication` ON `id` = `id_publication`;
CREATE OR REPLACE VIEW `#__jresearch_publication_recava_article` AS SELECT * FROM `#__jresearch_recava_article` JOIN `#__jresearch_publication` ON `id` = `id_publication`;
CREATE OR REPLACE VIEW `#__jresearch_publication_unpublished` AS SELECT * FROM `#__jresearch_unpublished` JOIN `#__jresearch_publication` ON `id` = `id_publication`;
CREATE OR REPLACE VIEW `#__jresearch_publication_proceedings` AS SELECT * FROM `#__jresearch_proceedings` JOIN `#__jresearch_publication` ON `id` = `id_publication`;
CREATE OR REPLACE VIEW `#__jresearch_publication_book` AS SELECT * FROM `#__jresearch_book` JOIN `#__jresearch_publication` ON `id` = `id_publication`;
CREATE OR REPLACE VIEW `#__jresearch_publication_incollection` AS SELECT * FROM `#__jresearch_incollection` JOIN `#__jresearch_publication` ON `id` = `id_publication`;
CREATE OR REPLACE VIEW `#__jresearch_publication_booklet` AS SELECT * FROM `#__jresearch_booklet` JOIN `#__jresearch_publication` ON `id` = `id_publication`;
CREATE OR REPLACE VIEW `#__jresearch_publication_conference` AS SELECT * FROM `#__jresearch_conference` JOIN `#__jresearch_publication` ON `id` = `id_publication`;
CREATE OR REPLACE VIEW `#__jresearch_publication_inbook` AS SELECT * FROM `#__jresearch_inbook` JOIN `#__jresearch_publication` ON `id` = `id_publication`;
CREATE OR REPLACE VIEW `#__jresearch_publication_patent` AS SELECT * FROM `#__jresearch_patent` JOIN `#__jresearch_publication` ON `id` = `id_publication`;
CREATE OR REPLACE VIEW `#__jresearch_publication_misc` AS SELECT * FROM `#__jresearch_misc` JOIN `#__jresearch_publication` ON `id` = `id_publication`;
CREATE OR REPLACE VIEW `#__jresearch_publication_phdthesis` AS SELECT * FROM `#__jresearch_phdthesis` JOIN `#__jresearch_publication` ON `id` = `id_publication`;
CREATE OR REPLACE VIEW `#__jresearch_publication_mastersthesis` AS SELECT * FROM `#__jresearch_mastersthesis` JOIN `#__jresearch_publication` ON `id` = `id_publication`;
CREATE OR REPLACE VIEW `#__jresearch_publication_manual` AS SELECT * FROM `#__jresearch_manual` JOIN `#__jresearch_publication` ON `id` = `id_publication`;
CREATE OR REPLACE VIEW `#__jresearch_publication_techreport` AS SELECT * FROM `#__jresearch_techreport` JOIN `#__jresearch_publication` ON `id` = `id_publication`;

INSERT INTO `#__jresearch_publication_type`(`name`) VALUES('recava_article');
INSERT INTO `#__jresearch_publication_type`(`name`) VALUES('article');
INSERT INTO `#__jresearch_publication_type`(`name`) VALUES('book');
INSERT INTO `#__jresearch_publication_type`(`name`) VALUES('booklet');
INSERT INTO `#__jresearch_publication_type`(`name`) VALUES('conference');
INSERT INTO `#__jresearch_publication_type`(`name`) VALUES('inbook');
INSERT INTO `#__jresearch_publication_type`(`name`) VALUES('incollection');
INSERT INTO `#__jresearch_publication_type`(`name`) VALUES('inproceedings');
INSERT INTO `#__jresearch_publication_type`(`name`) VALUES('manual');
INSERT INTO `#__jresearch_publication_type`(`name`) VALUES('mastersthesis');
INSERT INTO `#__jresearch_publication_type`(`name`) VALUES('misc');
INSERT INTO `#__jresearch_publication_type`(`name`) VALUES('patent');
INSERT INTO `#__jresearch_publication_type`(`name`) VALUES('phdthesis');
INSERT INTO `#__jresearch_publication_type`(`name`) VALUES('proceedings');
INSERT INTO `#__jresearch_publication_type`(`name`) VALUES('techreport');
INSERT INTO `#__jresearch_publication_type`(`name`) VALUES('unpublished');

INSERT INTO `#__jresearch_research_area`(`name`, `description`, `published` ) VALUES('Uncategorized', '', 1);