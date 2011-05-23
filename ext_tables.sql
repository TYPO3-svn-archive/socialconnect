CREATE TABLE tx_socialconnect_networks (
  uid int(11) NOT NULL auto_increment,
  tstamp int(11) unsigned DEFAULT '0' NOT NULL,
  crdate int(11) unsigned DEFAULT '0' NOT NULL,
  cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
  deleted tinyint(3) unsigned DEFAULT '0' NOT NULL,
  network varchar(50) DEFAULT '' NOT NULL,
  networkid int(11) unsigned DEFAULT '0' NOT NULL,
  name text NOT NULL,
  userkey text NOT NULL,
  secret text NOT NULL,
 
  PRIMARY KEY (uid),
);