SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


CREATE TABLE `autoreply` (
  `answer` varchar(500) NOT NULL,
  `mid` varchar(100) NOT NULL,
  `question` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


INSERT INTO `autoreply` (`answer`, `mid`, `question`) VALUES
(' Bye!! see you later..', '', 'bye'),
(' nice to hear that', '', 'fine'),
(' Don\'t be rude to me!', '', 'fuck'),
(' Hello friend', '', 'hello'),
(' Send me one or more words to know more about them. Ex: Chocolate  -Chocolate is a preparation of roasted and ground cacao seeds that is made in the form of a liquid, paste, or in a block, which may also be used as a flavoring ingredient in other foods.Chocolate is a range of foods derived from cocoa (cacao), mixed with fat (e.g., cocoa butter) and finely powdered sugar to produce a solid confectionery.', '', 'help'),
(' Hi... ðŸ˜Š', '', 'Hi'),
(' I\'m fine, thank you and how are you?', '', 'how are you?'),
(' Tell me what you want to know about in few words. Example: Mark Zuckerberg', '', 'I want to know about'),
(' Nice to meet you too', '', 'Nice to meet you'),
(' fine', '', 'ok'),
(' Send me few key words describing what you want to know about. Ex: Mark Zuckerberg', '', 'tell me'),
(' I am Master Wiki, I know everything about the world around you. Simply ask me what you want to know about.', '', 'what can you do?'),
(' \nI am Master Wiki, I know everything about the world around you. Simply ask me what you want to know about.', '', 'who are you');



CREATE TABLE `users` (
  `senderid` varchar(15) NOT NULL,
  `messagetext` varchar(500) NOT NULL,
  `mid` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



INSERT INTO `users` (`senderid`, `messagetext`, `mid`) VALUES
('103486161531412', 'cat', 'm_gS-sbJjM0KD6QW9ME-bFL7ZLk0ripLmWsFk_6n8yKb39YkFEeAqq6HMaXghfj3TakErFpuc6v8hx2OtGAcKqCg'),
('112118457331642', 'banana', 'm_bFEHbcdfcHU5CKYqGdiRrBypW1dBOim5K7rjBvLjgJWhch-aBX-vIfKmCDTlnmY9K_oyQlk4fbe1U5yRayIDNg'),
('245803481432165', 'Barack Obama', 'm_fRsott5uGHiG8tPZqJOohYOotlGtNZ95LI5c-NfhNoT5BW7W1i125uQMJF-XvkVlbsSY5HKCgrovq8aapVAyxw'),
('310940850916883', 'Vogue', 'm_f8OUt49F9XkX_MZx0nh_Ti7NKXWyw_rlWYEsn82eFCyYR_R6sdnYP6o2fOITgRvr5uxOdBhiuldqqRQQukypwA'),
('331127946896303', 'Srilanka', 'm_e9AYyDCDo62-GnhAQ6DdXfzYS6s5CxEIGe0ZoJAb16M8UJtsYj4q6j5DzZcJqS08EPz2biIdLxmmXz50NTzuEg'),
('335943373081071', 'Abhishek', 'm_UT1RT459tUgogvMeu3h76ifc5nZI0tdniLZ6BXLntJRfbNNRGg95mJ0nTb6vebSp1XaBMqi86O0yIrZCmIoqCQ'),
('336857384321033', 'sliit', 'm_5087bnl9Qv-ff_gCDA1fuyOhf_nSbW_vK_NZqgkxHRjdYK5m5z9aIczvYTVeuNMc1t7Bjr7mZCLfHBP4I1ucnA'),
('338056790205032', 'Fuck', 'm_QIROny7s0S87Nzwo5Sau5DEIuD8g9DAvYlXxB9nqtDa4fTJjMSmFyq9cTtl-diHUW_GN4YKTBR089HcKj60IQw'),
('339349642072979', 'Psychology', 'm_gttco5kgSUzcjhmGen8IHVw9RBXomSPbDfVi-R1O9J3Jdixh6iF_urBc7qmcjOhlw-r4Bpbj8BJtMehAt4qQhA'),
('340159832325643', 'Flowers', 'm_N7ABan9DvXrG-32_J5Njo38lQISFKocrRDtw8N23_ndoEctK2Tau4GR95a_DM_MqJ78Cz_Gbk7Hpcja-TGarVg'),
('346731325335545', 'Git', 'm_zsUmdk8rgS3e3HIuhb7NVpm_tDKpLyi0xCdVl0SJuZa21IPkrqXqly2GOdIBWTZInB8BOOVVKXgx_7WRZ8R2lQ'),
('349763255692509', 'Malaka', 'm_sBEUftmTX-E8WI9uHg3hP_vSE3DYLCcaoHsWoygLMWS5aa0Oa1ewacAp46IlywUcI5gn5z-T-L2aW6R7FRSVeg'),
('359317696077635', 'Okay very good', 'm_b4BhFF3FS0l-fCD8MlVYE3S5csn5wpkXDosWY89MZhWNdRi82PwQMYu-7JUvB_VZVGO0pqYMqX2xj8L8Y3OUHA'),
('365609536773556', 'Hi', 'm_HyGV7Rpd59VpkBUpoQT754BimXvvS3E0F2Tjuw2Xni67X9JxudoHqe1OLzh7wT-GHWCG3IsMjGOOI274r-nOXg'),
('374818139856783', 'Cat', 'm_A_yJzUgY3QkVlvKkYQs9OrONtj6fVkCQBupnke7DwHxYC0noPXsG2xyPFBIbKi49WD6oi7F_IgqjRKXgXA5abQ'),
('405165107485130', 'à¶±à·€ à·€à·Šâ€à¶ºà·à¶´à·à¶» à¶´à·’à¶½à·’à¶¶à¶³à·€', 'm_hdxEnTnEoyHEdHHMolrvIL404u_3-wjVc1wzYULPHzEK5pFJA-7pvvulr2aU0WR2Tks89-ujl0ekUzGv19A1yQ'),
('452911215049707', 'Tell me', 'm_qSa4UH9ofDuVXAjn_8cWKSl_hOlZyHFjU2fyP9N0jLF8PAtNN0LayeMpQwltYjbVBrhHZLW2jiOeWpU3BR6K3g');


ALTER TABLE `autoreply`
  ADD UNIQUE KEY `question` (`question`);


ALTER TABLE `users`
  ADD UNIQUE KEY `senderid` (`senderid`);
COMMIT;
