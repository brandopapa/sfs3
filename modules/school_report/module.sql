#
# ��ƪ�榡�G ``
#
# �бN�z����ƪ� CREATE TABLE �y�k�m��U�C
# �Y�L�A�h�бN���� module.sql �R���C

-- 
-- ��ƪ�榡�G `school_report_things`
-- 

CREATE TABLE `school_report_things` (
  `id` int(11) NOT NULL auto_increment,
  `weeks` tinyint(3) unsigned NOT NULL,
  `open_date` date NOT NULL,
  `title` varchar(60) NOT NULL,
  `content` text NOT NULL,
  `c_time` datetime NOT NULL,
  `teacher_sn` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `year_seme` varchar(6) NOT NULL,
  PRIMARY KEY  (`id`)
);

