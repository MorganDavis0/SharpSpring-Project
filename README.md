# SharpSpring-Project
The files present in this repo are for my application for SharpSpring only.

There should be 6 files present, index.php, dbconnect.php, login.php, navbar.php, newnote.php, and edit.php. On my end, I had these files in the htdocs folder of my xampp install. You may have other ways of setting up the site, but that is how I did it. I used MYSQL as my sql database for this project. 

I used the following command to create the c1 database: CREATE DATABASE c1;

I used the following commands to create a users table and notes table: CREATE TABLE `users` (`id` bigint(64) NOT NULL AUTO_INCREMENT, `name` varchar(255) NOT NULL, `email` varchar(255) NOT NULL, `password` varchar(255) NOT NULL, `updated_at` timestamp NULL DEFAULT NULL, `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP, PRIMARY KEY (`i`), UNIQUE KEY `email` (`email`)) ENGINE=InnoDB DEFAULT CHARSET=utf8; and CREATE TABLE `c1`.`notes` (`userid` BIGINT NOT NULL, `noteid` BIGINT NOT NULL AUTO_INCREMENT, `title` VARCHAR(100) NOT NULL, `note` VARCHAR(1000) NOT NULL, `created_on` VARCHAR(50) NOT NULL, PRIMARY KEY (`noteid`), INDEX `userid_idx` (`userid` ASC) VISIBLE, CONSTRAINT `userid` FOREIGN KEY (`userid`) REFERENCES `c1`.`users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION);

To insert the test user I used the following: INSERT INTO `users` (`id`, `name`, `email`, `password`, `updated_at`, `created_at`) values (1, "test", "test@test.com", '$2y$10$Q7hi.IQlFFY3A96BJveDtOPQ9Nf40i2Vf4QV0g8IoDYA8RZtgTD06', '2015-10-12 02:40:15', '2015-10-12 02:40:15');

Note that I did not use lumen routing in this project. I'm unfamiliar with it, so I decided to do as well as I could with what I knew and could find vs. try to learn something totally new to incorperate given the time. 

Note that edit.php isn't very functional. For some reason queries from that page wouldn't work, at least the update query. I have code commented out much of the unimplemented code in that one.

Lastly, the code presented here is a combination of personal knowledge, internet resources, and looking back at a past project.
