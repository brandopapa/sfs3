CREATE TABLE IF NOT EXISTS `12basic_ptc` (
  `sn` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `academic_year` tinyint(3) unsigned NOT NULL,
  `student_sn` int(10) unsigned NOT NULL,
  `card_no` varchar(20) DEFAULT NULL,
  `kind_id` tinyint(3) unsigned DEFAULT NULL,
  `disability_id` tinyint(3) unsigned DEFAULT NULL,
  `free_id` tinyint(3) unsigned DEFAULT NULL,
  `id_memo` VARCHAR(100) DEFAULT NULL,
  `score_nearby` tinyint(3) unsigned DEFAULT NULL,
  `score_remote` tinyint(3) unsigned DEFAULT NULL,
  `score_disadvantage` tinyint(3) unsigned DEFAULT NULL,
  `disadvantage_memo` varchar(100) DEFAULT NULL,
  `score_balance_health` tinyint(3) unsigned DEFAULT NULL,
  `score_balance_art` tinyint(3) unsigned DEFAULT NULL,
  `score_balance_complex` tinyint(3) unsigned DEFAULT NULL,
  `balance_memo` varchar(100) DEFAULT NULL,
  `score_association` float unsigned DEFAULT NULL,
  `score_service` float DEFAULT NULL,
  `score_fault` tinyint(3) unsigned DEFAULT NULL,
  `score_reward` float DEFAULT NULL,
  `score_competetion` tinyint(3) unsigned DEFAULT NULL,
  `score_fitness` float DEFAULT NULL,
  `diversification_memo` varchar(100) DEFAULT NULL,
  `score_exam_w` tinyint(3) unsigned DEFAULT NULL,
  `score_exam_c` tinyint(3) unsigned DEFAULT NULL,
  `score_exam_m` tinyint(3) unsigned DEFAULT NULL,
  `score_exam_e` tinyint(3) unsigned DEFAULT NULL,
  `score_exam_s` tinyint(3) unsigned DEFAULT NULL,
  `score_exam_n` tinyint(3) unsigned DEFAULT NULL,
  `exam_memo` varchar(100) DEFAULT NULL,
  `score_my_aspiration` tinyint(3) unsigned DEFAULT NULL,
  `score_domicile_suggestion` tinyint(3) unsigned DEFAULT NULL,
  `score_guidance_suggestion` tinyint(3) unsigned DEFAULT NULL,
  `personality_memo` varchar(100) NOT NULL,
  `aspiration_history` text,
  `update_sn` int(10) unsigned NOT NULL,
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `editable` enum('0','1') NOT NULL DEFAULT '1',
  PRIMARY KEY (`sn`),
  UNIQUE KEY `academic_year` (`academic_year`,`student_sn`),
  KEY `student_sn` (`student_sn`)
);

CREATE TABLE IF NOT EXISTS `12basic_kind_ptc` (
  `sn` int(10) unsigned NOT NULL auto_increment,
  `year_seme` varchar(4) NOT NULL,
  `kind_data` text NOT NULL,
  `disability_data` text NOT NULL,
  `free_data` text NOT NULL,
  PRIMARY KEY  (`sn`),
  UNIQUE KEY `year` (`year_seme`)
);