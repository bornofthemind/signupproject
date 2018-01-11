/* MySQL Query to create table in database with name: signindb*/


CREATE TABLE `entry_detail` (
		`entry_id` int(11) NOT NULL default '0',
		`entry_author` varchar(50) NOT NULL default '',
		`entry_dob` varchar(50) NOT NULL default '',
		`entry_email` varchar(100) NOT NULL default '',
	    `entry_url` varchar(100) NOT NULL default '',
	    `entry_location` varchar(50) NOT NULL default '',
		`entry_date` datetime NOT NULL default '0000-00-00 00:00:00',
		`entry_comments` text NOT NULL,
		`entry_referer` varchar(50) NOT NULL default '',
		`entry_ip` varchar(15) NOT NULL default '',
		`entry_hidden` enum('0','1') NOT NULL default '0'
	) ;