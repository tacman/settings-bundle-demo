CREATE TABLE `new_jokes` (
                             `ID` int(6) NOT NULL auto_increment,
                             `Category` varchar(255) default NULL,
                             `Joke` text,
                             PRIMARY KEY  (`ID`),
                             KEY `Category` (`Category`)
) ENGINE=MyISAM AUTO_INCREMENT=9986 DEFAULT CHARSET=latin1 AUTO_INCREMENT=9986 ;


INSERT INTO `new_jokes` VALUES (1, 'Random \r\njoke of the day', 'What''s the difference between Windows \r\n95 and a \r\nvirus? \r\nA virus does something.');
tac@tac-XPS-9320:~/survos/demos/settings-bundle-demo$ head ~/data/funny_jokes.sql -n 50
CREATE TABLE `new_jokes` (
                             `ID` int(6) NOT NULL auto_increment,
                             `Category` varchar(255) default NULL,
                             `Joke` text,
                             PRIMARY KEY  (`ID`),
                             KEY `Category` (`Category`)
) ENGINE=MyISAM AUTO_INCREMENT=9986 DEFAULT CHARSET=latin1 AUTO_INCREMENT=9986 ;


INSERT INTO `new_jokes` VALUES (1, 'Random \r\njoke of the day', 'What''s the difference between Windows \r\n95 and a \r\nvirus? \r\nA virus does something.');
INSERT INTO `new_jokes` VALUES (2, 'Random joke of the day', 'Q: What goes VROOM, SCREECH,VROOM, \r\n\r\nSCREECH,VROOM, SCREECH?\r\nA: A blonde going through a flashing red \r\nlight.');
INSERT INTO `new_jokes` VALUES (3, 'Email this funny joke to a friend!', 'What''s the difference \r\n\r\nbetween Windows 95 and a virus? \r\nA virus does something.');
