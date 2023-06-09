<?php
/**
* Class for generating some random text data, like human first/last/mid names, dates, etc.
* @name class.randomdata.lang-en.php
* Registering Russian (ru) first & last & patronimic names
* @Author Alexander Selifonov, <alex [at] selifan {dot} ru>
* @copyright Alexander Selifonov, <alex [at] selifan {dot} ru>
* @version 0.10 (started 2014-01-05)
* @Link http://www.selifan.ru
* @license http://opensource.org/licenses/BSD-3-Clause    BSD
* Base english first and last names were parsed/copy-pasted from http://www.world-english.org/
* modified 2015-04-13
*/ 
$options = array(
  'firstnames' => array(
    'm' => array(
    'Aaron', 'Abbott', 'Abel', 'Abner', 'Abraham', 'Adam', 'Addison', 'Adler', 'Adley', 'Adrian', 'Aedan'
    , 'Aiken', 'Alan', 'Alastair', 'Albern', 'Albert', 'Albion', 'Alden', 'Aldis', 'Aldrich', 'Alexander'
    , 'Alfie', 'Alfred', 'Algernon', 'Alston', 'Alton', 'Alvin', 'Ambrose', 'Amery', 'Amos', 'Andrew'
    , 'Angus', 'Ansel', 'Anthony', 'Archer', 'Archibald', 'Arlen', 'Arnold', 'Arthur', 'Arvel', 'Atwater'
    , 'Atwood', 'Aubrey', 'Austin', 'Avery', 'Axel', 'Baird', 'Baldwin', 'Barclay', 'Barnaby', 'Baron'
    , 'Barrett', 'Barry', 'Bartholomew', 'Basil', 'Benedict', 'Benjamin', 'Benton', 'Bernard', 'Bert', 'Bevis'
    , 'Blaine', 'Blair', 'Blake', 'Bond', 'Boris', 'Bowen', 'Braden', 'Bradley', 'Brandan', 'Brent'
    , 'Bret', 'Brian', 'Brice', 'Brigham', 'Brock', 'Broderick', 'Brooke', 'Bruce', 'Bruno', 'Bryant'
    , 'Buck', 'Bud', 'Burgess', 'Burton', 'Byron', 'Cadman', 'Calvert', 'Caldwell', 'Caleb', 'Calvin'
    , 'Carrick', 'Carl', 'Carlton', 'Carney', 'Carroll', 'Carter', 'Carver', 'Cary', 'Casey', 'Casper'
    , 'Cecil', 'Cedric', 'Chad', 'Chalmers', 'Chandler', 'Channing', 'Chapman', 'Charles', 'Chatwin', 'Chester'
    , 'Christian', 'Christopher', 'Clarence', 'Claude', 'Clayton', 'Clifford', 'Clive', 'Clyde', 'Coleman', 'Colin'
    , 'Collier', 'Conan', 'Connell', 'Connor', 'Conrad', 'Conroy', 'Conway', 'Corwin', 'Crispin', 'Crosby'
    , 'Culbert', 'Culver', 'Curt', 'Curtis', 'Cuthbert', 'Craig', 'Cyril'
    , 'Dale', 'Dalton', 'Damon', 'Daniel', 'Darcy', 'Darian', 'Darell', 'David', 'Davin', 'Dean', 'Declan'
    , 'Delmar', 'Denley', 'Dennis', 'Derek', 'Dermot', 'Derwin', 'Des', 'Dexter', 'Dillon', 'Dion'
    , 'Dirk', 'Dixon', 'Dominic', 'Donald', 'Dorian', 'Douglas', 'Doyle', 'Drake', 'Drew', 'Driscoll'
    , 'Dudley', 'Duncan', 'Durwin', 'Dwayne', 'Dwight', 'Dylan', 'Earl', 'Eaton', 'Ebenezer', 'Edan'
    , 'Edgar', 'Edric', 'Edmond', 'Edward', 'Edwin', 'Efrain', 'Egan', 'Egbert', 'Egerton', 'Egil'
    , 'Elbert', 'Eldon', 'Eldwin', 'Eli', 'Elias', 'Eliot', 'Ellery', 'Elmer', 'Elroy', 'Elton'
    , 'Elvis', 'Emerson', 'Emmanuel', 'Emmett', 'Emrick', 'Enoch', 'Eric', 'Ernest', 'Errol', 'Erskine'
    , 'Erwin', 'Esmond', 'Ethan', 'Ethen', 'Eugene', 'Evan', 'Everett', 'Ezra', 'Fabian', 'Fairfax'
    , 'Falkner', 'Farley', 'Farrell', 'Felix', 'Fenton', 'Ferdinand', 'Fergal', 'Fergus', 'Ferris', 'Finbar'
    , 'Fitzgerald', 'Fleming', 'Fletcher', 'Floyd', 'Forbes', 'Forrest', 'Foster', 'Fox', 'Francis', 'Frank'
    , 'Frasier', 'Frederick', 'Freeman'

    , 'Gabriel', 'Gale', 'Galvin', 'Gardner', 'Garret', 'Garrick', 'Garth', 'Gavin', 'George', 'Gerald', 'Gideon'
    , 'Gifford', 'Gilbert', 'Giles', 'Gilroy', 'Glenn', 'Goddard', 'Godfrey', 'Godwin', 'Graham', 'Grant'
    , 'Grayson', 'Gregory', 'Gresham', 'Griswald', 'Grover', 'Guy', 'Hadden', 'Hadley', 'Hadwin', 'Hal'
    , 'Halbert', 'Halden', 'Hale', 'Hall', 'Halsey', 'Hamlin', 'Hanley', 'Hardy', 'Harlan', 'Harley'
    , 'Harold', 'Harris', 'Hartley', 'Heath', 'Hector', 'Henry', 'Herbert', 'Herman', 'Homer', 'Horace'
    , 'Howard', 'Hubert', 'Hugh', 'Humphrey', 'Hunter', 'Ian', 'Igor', 'Irvin', 'Isaac', 'Isaiah'
    , 'Ivan', 'Iver', 'Ives'

    ,'Jack', 'Jacob', 'James', 'Jarvis', 'Jason', 'Jasper', 'Jed', 'Jeffrey', 'Jeremiah', 'Jerome', 'Jesse'
    , 'John', 'Jonathan', 'Joseph', 'Joshua', 'Justin', 'Kane', 'Keene', 'Keegan', 'Keaton', 'Keith'
    , 'Kelsey', 'Kelvin', 'Kendall', 'Kendrick', 'Kenneth', 'Kent', 'Kenway', 'Kenyon', 'Kerry', 'Kerwin'
    , 'Kevin', 'Kiefer', 'Kilby', 'Kilian', 'Kim', 'Kimball', 'Kingsley', 'Kirby', 'Kirk', 'Kit'
    , 'Kody', 'Konrad', 'Kurt', 'Kyle', 'Lambert', 'Lamont', 'Lancelot', 'Landon', 'Landry', 'Lane'
    , 'Lars', 'Laurence', 'Lee', 'Leith', 'Leonard', 'Leroy', 'Leslie', 'Lester', 'Lincoln', 'Lionel'
    , 'Lloyd', 'Logan', 'Lombard', 'Louis', 'Lowell', 'Lucas', 'Luther', 'Lyndon'

    , 'Maddox', 'Magnus', 'Malcolm', 'Melvin', 'Marcus', 'Mark', 'Marlon', 'Martin', 'Marvin', 'Matthew', 'Maurice'
    , 'Max', 'Medwin', 'Melville', 'Merlin', 'Michael', 'Milburn', 'Miles', 'Monroe', 'Montague', 'Montgomery'
    , 'Morgan', 'Morris', 'Morton', 'Murray', 'Nathaniel', 'Neal', 'Neville', 'Nicholas', 'Nigel', 'Noel'
    , 'Norman', 'Norris', 'Olaf', 'Olin', 'Oliver', 'Orson', 'Oscar', 'Oswald', 'Otis', 'Owen'

    , 'Paul', 'Paxton', 'Percival', 'Perry', 'Peter', 'Peyton', 'Philbert', 'Philip', 'Phineas', 'Pierce', 'Quade'
    , 'Quenby', 'Quillan', 'Quimby', 'Quentin', 'Quinby', 'Quincy', 'Quinlan', 'Quinn', 'Ralph', 'Ramsey'
    , 'Randolph', 'Raymond', 'Reginald', 'Renfred', 'Rex', 'Rhett', 'Richard', 'Ridley', 'Riley', 'Robert'
    , 'Roderick', 'Rodney', 'Roger', 'Roland', 'Rolf', 'Ronald', 'Rory', 'Ross', 'Roswell', 'Roy'
    , 'Royce', 'Rufus', 'Rupert', 'Russell', 'Ryan'

    , 'Samson', 'Samuel', 'Scott', 'Sean', 'Sebastian', 'Seth', 'Seymour', 'Shamus', 'Shawn', 'Shelley', 'Sherard'
    , 'Sheridan', 'Sherlock', 'Sherman', 'Sherwin', 'Sidney', 'Sigmund', 'Silas', 'Simon', 'Sinclair', 'Sloane'
    , 'Solomon', 'Spencer', 'Stacy', 'Stanley', 'Stephen', 'Sterling', 'Stewart', 'Theobold', 'Theodore', 'Thomas'
    , 'Timothy', 'Titus', 'Tobias', 'Toby', 'Todd', 'Tony', 'Travis', 'Trent', 'Trevor', 'Tristan'
    , 'Troy', 'Truman', 'Tyler', 'Udolf', 'Unwin', 'Uriah'
    , 'Vance', 'Vaughan', 'Vernon', 'Victor', 'Vincent', 'Wallace', 'Walter', 'Walton', 'Ward', 'Warren', 'Washington'
    , 'Wayne', 'Wesley', 'Wilbur', 'Willard', 'William', 'Willis', 'Winston', 'Winthrop', 'Wyatt', 'Wylie'
    , 'Wyman', 'Zachariah', 'Zachary', 'Zebadiah', 'Zane', 'Zebediah'

    )
    ,'f' => array(
    'Abigail', 'Ada', 'Adelaide', 'Adrienne', 'Agatha', 'Agnes', 'Aileen', 'Aimee', 'Alanna', 'Alarice', 'Alda'
    , 'Alexandra', 'Alice', 'Alina', 'Alison', 'Alma', 'Amanda', 'Amaryllis', 'Amber', 'Anastasia', 'Andrea'
    , 'Angela', 'Angelica', 'Anita', 'Ann', 'Annabelle', 'Annette', 'Anthea', 'April', 'Ariana', 'Arleen'
    , 'Astrid', 'Audrey'
    , 'Barbara', 'Beata', 'Beatrice', 'Becky', 'Belinda', 'Belle', 'Bernadette', 'Bernice', 'Bertha', 'Bertina', 'Beryl'
    , 'Bess', 'Beth', 'Bettina', 'Beverly', 'Bianca', 'Blair', 'Blanche', 'Blythe', 'Bonnie', 'Brenda'
    , 'Briana', 'Brigid', 'Brittany', 'Brooke'
    , 'Caitlin', 'Camille', 'Carissa', 'Carla', 'Carly', 'Carmen', 'Carrie', 'Cherise', 'Catherine', 'Charity', 'Charlene'
    , 'Chelsea', 'Cheryl', 'Chloe', 'Christine', 'Claire', 'Clarissa', 'Coral', 'Courtney', 'Cynthia'
    , 'Danielle', 'Daphne', 'Darlene', 'Davida', 'Dawn', 'Deborah', 'Deirdre', 'Delilah', 'Denise', 'Diana', 'Dominica'
    , 'Dominique', 'Donna', 'Dora', 'Doris', 'Drucilla'
    , 'Echo', 'Eda', 'Edana', 'Edeline', 'Edith', 'Edlyn', 'Edna', 'Edwina', 'Effie', 'Eileen', 'Elaine'
    , 'Eleanor', 'Elena', 'Elga', 'Elise', 'Eliza', 'Elizabeth', 'Ella', 'Ellen', 'Eloise', 'Elsie'
    , 'Elvira', 'Emeline', 'Emily', 'Emma', 'Erika', 'Ernestine', 'Esmeralda', 'Erin', 'Estelle', 'Estra'
    , 'Ethel', 'Eudora', 'Eugenia', 'Eunice', 'Eva'
    , 'Faith', 'Fannie', 'Farrah', 'Fawn', 'Faye', 'Fedora', 'Felicia', 'Fern', 'Fiona', 'Flora', 'Frances'
    , 'Freda', 'Frederica'
    , 'Gabrielle', 'Gale', 'Gaye', 'Geneva', 'Genevieve', 'Georgette', 'Georgia', 'Geraldine', 'Germaine', 'Gertrude', 'Gilda'
    , 'Gillian', 'Gladys', 'Gloria', 'Glynnis', 'Grace', 'Guinevere', 'Gwen', 'Gwynne'
    , 'Haley', 'Hanna', 'Harriet', 'Harley', 'Harmony', 'Hattie', 'Hazel', 'Heather', 'Helen', 'Henrietta', 'Hetty'
    , 'Hilda', 'Holly', 'Honey', 'Hope', 'Hortense'
    , 'Ida', 'Imogen', 'Ingrid', 'Irene', 'Iris', 'Ivy', 'Ivory'
    , 'Jacqueline', 'Jade', 'Jane', 'Janet', 'Janice', 'Jasmine', 'Jeanne', 'Jemima', 'Jennifer', 'Jessica', 'Jewel'
    , 'Jillian', 'Joan', 'Jocelyn', 'Joanna', 'Josephine', 'Joy', 'Judith', 'Juliana', 'Julie', 'June', 'Justine'
    , 'Kacey', 'Kara', 'Karen', 'Kate', 'Katherine', 'Kay', 'Kayla', 'Keely', 'Kelsey', 'Kendra', 'Kerri'
    , 'Kirstyn', 'Kyla'
    , 'Lacey', 'Lane', 'Lara', 'Larina', 'Larissa', 'Laura', 'Laverna', 'Leah', 'Leanne', 'Lee', 'Leslie'
    , 'Leticia', 'Lilah', 'Linda', 'Linette', 'Lindsay', 'Lisa', 'Livia', 'Lizzie', 'Lois', 'Lola'
    , 'Lorelei', 'Lorena', 'Lorraine', 'Louisa', 'Lucia', 'Lucinda', 'Lulu', 'Luna', 'Lynn'
    , 'Mabel', 'Madeline', 'Madge', 'Magda', 'Maggie', 'Maia', 'Maisie', 'Mandy', 'Marcia', 'Margaret', 'Margot'
    , 'Maria', 'Marnia', 'Marissa', 'Marta', 'Martina', 'Mary', 'Matilda', 'Maude', 'Maura', 'Maureen'
    , 'Mavis', 'Maxine', 'Megan', 'Melanie', 'Melinda', 'Melissa', 'Melody', 'Melvina', 'Mercy', 'Meris'
    , 'Merle', 'Michelle', 'Mildred', 'Millicent', 'Minerva', 'Mirabelle', 'Miranda', 'Miriam', 'Misty', 'Moira'
    , 'Molly', 'Mona', 'Monica', 'Mora', 'Morgan', 'Muriel', 'Myra', 'Myrtle'
    , 'Nadia', 'Nancy', 'Naomi', 'Natalie', 'Nathania', 'Nell', 'Nerissa', 'Nerita', 'Nessa', 'Nicolette', 'Nina'
    , 'Noelle', 'Nola', 'Nora', 'Norma', 'Nydia'
    , 'Octavia', 'Odette', 'Olga', 'Olivia', 'Opal', 'Ophelia', 'Oprah', 'Oriel', 'Orlantha', 'Orva'
    , 'Page', 'Pamela', 'Pandora', 'Pansy', 'Patience', 'Patricia', 'Patty', 'Paula', 'Pearl', 'Peggy', 'Penelope'
    , 'Philippa', 'Philomena', 'Phoebe', 'Phyllis', 'Polly', 'Primavera', 'Primrose', 'Priscilla', 'Prudence', 'Prunella'
    , 'Rachel', 'Ramona', 'Rebecca', 'Regina', 'Renata', 'Rhea', 'Rhoda', 'Rita', 'Roberta', 'Robin', 'Rosa'
    , 'Rose', 'Rosalind', 'Rosanne', 'Rosemary', 'Rowena', 'Roxanne', 'Ruby', 'Ruth'
    , 'Sabrina', 'Sacha', 'Sadie', 'Salena', 'Sally', 'Salome', 'Samantha', 'Sandra', 'Sapphire', 'Sarah', 'Scarlett'
    , 'Selene', 'Serena', 'Shana', 'Shannon', 'Sharon', 'Sheila', 'Shirley', 'Sibley', 'Sibyl', 'Silver'
    , 'Simona', 'Sirena'
    , 'Tabitha', 'Talia', 'Tamara', 'Tammy', 'Tanya', 'Tara', 'Tasha', 'Tatum', 'Teresa', 'Tess', 'Thalia'
    , 'Thea', 'Thelma', 'Theodora', 'Thomasina', 'Thora', 'Tiffany', 'Tilda', 'Timothea', 'Tina', 'Tracy'
    , 'Trina', 'Trista', 'Trixie', 'Tuesday', 'Tyne'
    , 'Udele', 'Ula', 'Ulrica', 'Ulva', 'Una', 'Unity', 'Ursa', 'Ursula'
    , 'Valda', 'Valerie', 'Vanessa', 'Vania', 'Veleda', 'Vera', 'Verda', 'Veronica', 'Victoria', 'Violet', 'Virginia'
    , 'Vita', 'Vivian'
    , 'Wanda', 'Wenda', 'Whitney', 'Wilda', 'Willa', 'Willette', 'Willow', 'Wilona', 'Winifred', 'Winona', 'Wynne'
    , 'Yolanda', 'Yvette', 'Yvonne'
    , 'Zea', 'Zelda', 'Zelene', 'Zera', 'Zoe'

    )
  )
 ,'lastnames' => array('Abbott','Beckham','Black','Braxton','Brennan'
   ,'Brock','Bryson','Cadwell','Cage','Carson','Chandler','Cohen','Cole','Corbin','Dallas','Dalton','Dane','Donovan','Easton'
   ,'Fisher','Fletcher','Grady','Greyson','Griffin','Gunner','Hayden','Hudson'
   ,'Hunter','Jacoby','Jagger','Jaxon','Jett','Kade'
   ,'Kane','Keating','Keegan','Kingston','Kobe','Kyler','Lennon','Logan','Marley'
   ,'Mason','Maverick','Nolan','Parker','Paxton'
   ,'Peyton','Pierce','Porter','Quinn','Ackerman','Aldaine','Alvarez','Anders'
   ,'Babcock','Bachelor','Bagwell','Bailey','Cameron','Camp'
   ,'Camp','Canterbury','Carey','Carlisle','Cruso','Daily','Dacanay','Dean'
   ,'Dreygon','East','Eaton','England','Espinoza','Evans'
   ,'Farris','Faulkner','Feliciano','Ferguson','Gall','Gallegos','Galvan'
   ,'Gamble','Garcia','Gretzky','Hackett','Haddock','Haines','Hernandez','Ingalls'
   ,'Inman','Iver','Jaquez'
   ,'Jarrett','Jarvis','Keefe','Keifer','Kendall','Larson','Laughlin','Lawrence'
   ,'Maestas','Magnuson','Majors'
   ,'Nixon','Noble','North','Osborne','Oswald','Perez','Petty','Pevensey','Paasch'
   ,'Pfeiffer','Phelps'
   ,'Polanski','Quaid','Quaker','Radford','Radner','Ralston','Rodrigues'
   ,'Rosati','Sadler','Sanchez','Searle','Sedgwick','Taheny','Thatcher','Torres'
   ,'Townsend','Tredway','Tremaine','Urban'
   ,'Usher','Van Zandt','Vladamire','Webster','Weinstein','Yeager','Yeats','Young'
   ,'Zedler','Zimmerman','Zuniga','Zabinski'
   , 'Dabney', 'Diamond', 'Earp', 'Fairbanks', 'Fisk', 'Dallesandro', 'Dixon', 'Eberstark', 'Fairchild', 'Fitzgerald', 'Dalton'
   , 'Dobra', 'Elder', 'Fangio', 'Fitzpatrick', 'Dandridge', 'Dodge', 'Eldridge', 'Farrell', 'Flair', 'Darby'
   , 'Donahue', 'Ellenburg', 'Fawcett', 'Flagg', 'Dark', 'Donnelly', 'England', 'Fawzi', 'Flanagan', 'Decarlo'
   , 'Donovan', 'Epps', 'Fenner', 'Fleiss', 'Decker', 'Dooley', 'Eubanks', 'Ferber', 'Fletcher', 'Delpy'
   , 'Dubois', 'Everhart', 'Ferguson', 'Flood', 'Dempsey', 'Dumont', 'Finch', 'Floquet', 'Derbyshire', 'Finchum'
   , 'Flynn', 'Devereaux', 'Fingermann', 'Foley', 'Gaither', 'Greenway', 'Hale', 'Herrera', 'Hogan', 'Idelson'
   , 'Gallagher', 'Greer', 'Halleck', 'Hess', 'Holiday', 'Inch', 'Gannon', 'Grell', 'Hammer', 'Hester'
   , 'Holland', 'Ingram', 'Gardel', 'Grimes', 'Hammond', 'Hickey', 'Hood', 'Inoki', 'Gillis', 'Griffith'
   , 'Hardin', 'Higgins', 'Horry', 'Irons', 'Glaser', 'Grizzly', 'Hardy', 'Hightower', 'Hostetler', 'Irvin'
   , 'Glass', 'Grubbs', 'Harker', 'Hilliard', 'Huffman', 'Irwin', 'Glick', 'Guest', 'Harper', 'Hindley'
   , 'Hull', 'Ivanenko', 'Goddard', 'Hartman', 'Hitchcock', 'Husher', 'Ives', 'Golden', 'Hawk', 'Hoagland'
   , 'Huxley', 'Gore', 'Head', 'Hobbs', 'Huxx', 'Goulding', 'Healy', 'Hobgood', 'Hyde', 'Graber'
   , 'Heller', 'Hodder', 'Oakley', 'ORourke', 'Panera', 'Platt', 'Quaice', 'Race', 'Oaks', 'Orr'
   , 'Patterson', 'Plunkett', 'Quaid', 'Ramos', 'O�Brien', 'Ortega', 'Pavlov', 'Pollock', 'Quall', 'Redgrave'
   , 'ODonnell', 'Orton', 'Pawar', 'Post', 'Quarters', 'Redman', 'Oduya', 'Oswald', 'Paxton', 'Powell'
   , 'Quick', 'Renfro', 'Ogden', 'Ottinger', 'Peck', 'Powers', 'Quinn', 'Renshaw', 'Ogle', 'Overholt'
   , 'Pell', 'Prado', 'Rhodes', 'Ogletree', 'Owusu', 'Perrin', 'Previn', 'Riddle', 'OLeary', 'Pickering'
   , 'Price', 'Riggs', 'October', 'Pinder', 'Puller', 'Riker', 'Olson', 'Pinzer', 'Punch', 'Ripperton'
   , 'Onassis', 'Piper', 'Putnam', 'Romo', 'Opilio', 'Pittman', 'Rosenberg', 'Sands', 'Shippen', 'Stamper'
   , 'Tanaka', 'Udder', 'Vega', 'Sarkis', 'Shivers', 'Stapleton', 'Tapp', 'Underhill', 'Vess', 'Sasaki'
   , 'Shute', 'Steele', 'Taymor', 'Unger', 'Vestine', 'Savage', 'Silver', 'Stelly', 'Temple', 'Vickers'
   , 'Savoy', 'Sinclair', 'Stiner', 'Terrella', 'Voight', 'Saxon', 'Skinner', 'Stitchen', 'Thain', 'Volek'
   , 'Scardino', 'Sloane', 'Stoneking', 'Thorisdottir', 'Seagate', 'Small', 'Story', 'Tibbs', 'Sereno', 'Smoker'
   , 'Stroud', 'Tippett', 'Shea', 'Soo', 'Sullivan', 'Tooms', 'Sheehan', 'Soria', 'Sweeney', 'Tracy'
   , 'Shields', 'Sorrow', 'Swift', 'Tripper', 'Seibert', 'Spacek', 'Sykes', 'Trumbald', 'Wadd', 'Whitner'
   , 'Xavier', 'Yates', 'Zant', 'Wagner', 'Wight', 'Yeti', 'Zavaroni', 'Wainwright', 'Wilde', 'Yipp'
   , 'Zedillo', 'Wallace', 'Winchell', 'Yogo', 'Zeller', 'Walsh', 'Winchester', 'Yost', 'Zelter', 'Warrick'
   , 'Winters', 'Younger', 'Zimmerman', 'Watson', 'Winthrop', 'Zmich', 'Weaver', 'Wire', 'Zook', 'Wells'
   , 'Witt', 'Zubarry', 'Wexler', 'Wixx', 'Whalen', 'Wolfe', 'Wheeler', 'Wolfenstein', 'Whesker', 'Wong'

 )
 ,'patrnames' => array(
   'm' => array()
  ,'f' => array()
 )
 ,'lastname_modifier' => false # 'lastname_modifier_ru'
);

// reegister data for the language
RandomData::registerLanguage('en', $options);

