CREATE TABLE `exhibits` (
  `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `source_url` text NOT NULL,
  `path` text NOT NULL
);

INSERT INTO `exhibits` (`id`, `title`, `source_url`, `path`) VALUES
(1, 'A Room with a View by E. M. Forster', 'https://www.gutenberg.org/ebooks/2641', 'A Room with a View.txt'),
(2, 'New National Gallery building (west and south facade; sculpture «Têtes et Queue» by Alexander Calder) in Berlin, Germany', 'https://commons.wikimedia.org/wiki/File:Berlin_Neue_Nationalgalerie_asv2021-11_img1.jpg', 'Berlin_Neue_Nationalgalerie_asv2021-11_img1.jpg'),
(3, 'Breil-Brigels Outflow of river Flem in Lag da Breil', 'https://commons.wikimedia.org/wiki/File:Breil-Brigels,_Lag_da_Breil-_Flem._23-09-2022._(d.j.b)_04.jpg', 'Breil-Brigels,_Lag_da_Breil-_Flem._23-09-2022._(d.j.b)_04.jpg'),
(4, 'Clouded yellows (Colias croceus) mating, Pirin National Park, Bulgaria', 'https://commons.wikimedia.org/wiki/File:Clouded_yellows_(Colias_croceus)_mating_Bulgaria.jpg', 'Clouded_yellows_(Colias_croceus)_mating_Bulgaria.jpg'),
(5, 'Experiment with lens ball and light stick (white light against black background)', 'https://commons.wikimedia.org/wiki/File:Glaskugel_--_2022_--_9849.jpg', 'Glaskugel_--_2022_--_9849.jpg'),
(6, 'Aerial view of a flock of sheep with a shepherd in China', 'https://commons.wikimedia.org/wiki/File:Herding_sheep353_(edited).jpg', 'Herding_sheep353_(edited).jpg'),
(7, 'Southeast view of the Romanesque abbey church ruin in Paulinzella, Germany', 'https://commons.wikimedia.org/wiki/File:Paulinzella_abbey_church,_2022-05-28,_01.jpg', 'Paulinzella_abbey_church,_2022-05-28,_01.jpg'),
(8, 'Red-and-green macaw (Ara chloropterus) juvenile, the Pantanal, Brazil', 'https://commons.wikimedia.org/wiki/File:Red-and-green_macaw_(Ara_chloropterus)_juvenile.JPG', 'Red-and-green_macaw_(Ara_chloropterus)_juvenile.JPG'),
(9, 'Romeo and Juliet by William Shakespeare', 'https://www.gutenberg.org/ebooks/1513', 'Romeo and Juliet.txt'),
(10, 'The Langkofel and the Seiser Alm in South Tyrol', 'https://commons.wikimedia.org/wiki/File:Saslonch_y_Sela_da_Mont_S%C3%ABuc.jpg', 'Saslonch_y_Sela_da_Mont_Sëuc.jpg'),
(11, 'A Re 4/4 II and a Re 6/6 haul a southbound intermodal freight train on the Gotthard line just outside Erstfeld (visible in the background), Switzerland', 'https://commons.wikimedia.org/wiki/File:SBB_Re_4-4_II_and_Re_6-6_above_Erstfeld.jpg', 'SBB_Re_4-4_II_and_Re_6-6_above_Erstfeld.jpg');