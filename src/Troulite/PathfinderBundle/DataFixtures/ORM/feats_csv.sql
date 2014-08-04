DROP TABLE feats_csv;
CREATE TABLE `feats_csv` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  type LONGTEXT
       COLLATE utf8_unicode_ci NOT NULL,
  shortdescription LONGTEXT
              COLLATE utf8_unicode_ci NOT NULL,
  prerequisites LONGTEXT
                COLLATE utf8_unicode_ci NOT NULL,
  prerequisitie_feats LONGTEXT
                      COLLATE utf8_unicode_ci NOT NULL,
  benefit LONGTEXT
          COLLATE utf8_unicode_ci NOT NULL,
  normal LONGTEXT
         COLLATE utf8_unicode_ci NOT NULL,
  special LONGTEXT
          COLLATE utf8_unicode_ci NOT NULL,
  source LONGTEXT
         COLLATE utf8_unicode_ci NOT NULL,
  full_text LONGTEXT
           COLLATE utf8_unicode_ci NOT NULL,
  teamwork LONGTEXT
           COLLATE utf8_unicode_ci NOT NULL,
  critical LONGTEXT
           COLLATE utf8_unicode_ci NOT NULL,
  grit LONGTEXT
       COLLATE utf8_unicode_ci NOT NULL,
  style LONGTEXT
        COLLATE utf8_unicode_ci NOT NULL,
  performance LONGTEXT
              COLLATE utf8_unicode_ci NOT NULL,
  racial LONGTEXT
         COLLATE utf8_unicode_ci NOT NULL,
  companion_familiar LONGTEXT
                     COLLATE utf8_unicode_ci NOT NULL,
  race_name LONGTEXT
            COLLATE utf8_unicode_ci NOT NULL,
  note LONGTEXT
       COLLATE utf8_unicode_ci NOT NULL,
  goal LONGTEXT
       COLLATE utf8_unicode_ci NOT NULL,
  completion_benefit LONGTEXT
                     COLLATE utf8_unicode_ci NOT NULL,
  multiples LONGTEXT
            COLLATE utf8_unicode_ci NOT NULL,
  suggested_traits LONGTEXT
                   COLLATE utf8_unicode_ci NOT NULL,
  effects LONGTEXT
          COLLATE utf8_unicode_ci NOT NULL,
) ENGINE=CSV DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

load data local infile '/media/perso/PhpstormProjects/Pathfinder/src/Troulite/PathfinderBundle/DataFixtures/ORM/feats.csv' into table feats_csv fields terminated by ','
  enclosed by '"'
  lines terminated by '\n';