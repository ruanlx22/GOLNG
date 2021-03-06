<?php
//resetDatabase.php
//error report
ini_set('display_errors',1);
ini_set('display_startup_errors' ,1);
error_reporting(E_ALL);
//ensure user name and password fit for your phpadmin
$server = "localhost";
$userName = "root";
$password = "";

//connect to database
$connection = mysqli_connect($server, $userName, $password);

// die if connection is invalid
if (!$connection){
  die("Connection to DB failed :" . mysqli_connect_error() . "</br>");
}

echo  "Successfully connected to DB!" . "</br>";

if (!$connection){
    die("Connection to DB failed :" . mysqli_connect_error() . "</br>");
}

//Dropping old database
$sql = "DROP DATABASE IF EXISTS GOLNG";
if ($connection->query($sql) === TRUE){
    echo "Database dropped successfully!" . "</br>";
} else {
    echo "Error droppping database!" . $connection->error . "</br>" ;
}

//Create new database
$sql  = "CREATE DATABASE GOLNG CHARACTER SET utf8 COLLATE utf8_general_ci";
if ($connection->query($sql) === TRUE){
    echo "Database created successfully!" . "</br>";
} else {
    echo "Error creating database!" . $connection->error . "</br>" ;
}

//Grant access to the db user
$sql = "GRANT ALL ON GOLNG.* TO 'GOLNG'@'localhost' IDENTIFIED BY 'GOLNG'";
if ($connection->query($sql) === TRUE){
    echo "Access granted successfully!" . "</br>";
} else {
    echo "Error granting access database!" . $connection->error . "</br>";
}

//select GOLNG database
mysqli_select_db($connection,"GOLNG");

//Tables-Begin
//Add table here

//user_table
$sql = "CREATE TABLE userinfo (
id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
name varchar(100) DEFAULT NULL,
password varchar(50) DEFAULT NULL,
company int NOT NULL
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci";

if ($connection->query($sql) === true) {
    echo "userinfo table created successfully" . "</br>";
} else {
    echo "Error in creating userinfo table " . $connection->error . "</br>";
}

//company table 
$sql = "CREATE TABLE company (
id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
name varchar(100) DEFAULT NULL,
lat DOUBLE DEFAULT NULL,
lon DOUBLE DEFAULT NULL,
description text NOT NULL,
url varchar(255) NOT NULL,
image varchar(255) NOT NULL,
category varchar(50) NOT NULL
)ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci";

if ($connection->query($sql) === true) {
    echo "company table created successfully" . "</br>";
} else {
    echo "Error in creating company table " . $connection->error . "</br>";
}

//Here add userinfo
$sql = "INSERT INTO userinfo (name, password, company)
        VALUES
        ('nero', '22222', '1')";

if($connection->query($sql) === TRUE){
  echo " userinfo INSERTED successfully!" . "</br>";
}else {
  echo "Error INSERTING ingredients DATA!" . $connection->error . "</br>" ;
}

//here add companyinfo 
$sql = "INSERT INTO company (id, name, lat, lon, description, url, image, category)
        VALUES
                (NULL ,'WhiteSmoke AB', '57.688543', '11.906423', 'White Smoke run a consultacy business under the brand name White Smoke Consulting. The consulting part of White Smoke assist clients with  technical, commersial and regulatory expertise as well as project management services related to LNG as marine fuel and LNG Bunkering. White Smoke is also a part owner of White Smoke Shipping AB, a company dedicated to the supply of LNG feedering and bunkering services. ', 'http://www.whitesmoke.se', 'http://www.whitesmoke.se/images/WS1%20low%20wide%20small%202%20text.jpg', 'Consulting' ),
        (NULL ,'AGA Gas AB','59.349846','18.144529','Industrial gases from AGA play a crucial part in metallurgical processes, in chemical industry, food industry, environmental protection, while manufacturing glass and electronics, construction, pharmaceutical industry and research and development.','http://www.aga.com/international/web/lg/aga/like35agacom.nsf/docbyalias/homepage','http://www.aga.se/internet.lg.lg.swe/sv/images/aga_208x104586_117170.png?v=3.0','Consulting'),
        (NULL ,'GDF Suez','50.014739','14.423575','Biggest utility in the world and is one of the leading LNG playes in the world and main LNG  importer in Europé. Involved in North Stream project to transport Russian LNG to Europé. NORDSTREAM = 9% owner','http://www.gdfsuez.com/en/group/governance/operational-organization/global-gas-lng/','https://www.engie.com/wp-content/themes/gdfsuez/assets/images/logo-scroll.png','Shipping'),
        (NULL ,'DNV (Det Morske Veritas)','59.888103','10.562526','DNV (Det Norske Veritas) is an independent foundation with the purpose of safeguarding life, property, and the environment. Our history goes back to 1864, when the foundation was established in Norway to inspect and evaluate the technical condition of Norwegian merchant vessels.','http://www.dnv.com/','https://dnvglcom.azureedge.net/static/images/dnvgllogo_large.png','Research'),
        (NULL ,'SIS · Swedish Standards Institute','59.346345','18.0299142','ISO TC 67 WG10 PT1 committee by SIS to develop the first international accepted standard for LNG bunkering','http://www.sis.se/','https://www.sis.se/contentassets/52956d07cf2e4fb49c8196d78311b4e1/logo.png','Research'),
        (NULL ,'CIMET \(Centre for International Maritime Education and Training\)','56.854041','14.833023','This project will establish an international, STCW compliant, Centre for International Maritime Education and Training \(CIMET\) involving six partner institutions in the EU and Canada. Multilateral cooperation in the development of curricula and student exchanges in this highly focused area of vocational education will generate considerable added value for each participating institution as they develop their courses and programmes to comply with STCW requirements as set down by the International Maritime Organisation \(IMO\). The development of computer and web-based course materials will also be an important output of this collaboration.','http://lnu.se/schools/kalmar-maritime-academy/research/previous-projects/cimet?l=en','https://lnu.se/globalassets/lnu_wordmark_symbol_kalmar_vaxjo_cmyk.png','Training'),
        (NULL ,'Volvo Trucks','58.902926','17.946529','One of the top 3 heavy truck manufacturers. Volvo Trucks is enhancing its focus on alternative fuels with the launch of the new Volvo FM MethaneDiesel. This truck is powered by up to 75 percent gas. In addition,work on use of LNG powered trucks','http://www.volvotrucks.com/','https://www.volvocars.com/static/images/volvo-logo-scaled.png','end-user technologies'),
        (NULL ,'CRYO AB','57.7016021','11.8320394','CRYO AB\'s productline includes a large variety of LNG equipment, both onshore and offshore. The company’s LNG programme includes complete LNG receiving terminals, semi-trailer for land transport, fuel tanks for ships and ferries, as well as gas supply back-up systems and mobile equipment for the testing of gas turbines.','http://www.cryo.se/','https://www.linde-engineering.com/internet.global.lindeengineering.global/en/images/linde_gr_208x10419_1386.png?v=4.0','Shipbuilding & Repair'),
        (NULL ,'STENA LNG','57.701218','11.94566','Stena LNG is committed to maintain the position as one of the world’s best in quality, health, safety and environment (“QHSE”) management system, a position that is associated with the Stena brand and has been built up during the 30 years as owners and operators of oil and product tankers. The Company’s credo is .Gas should always travel First Class…','http://www.stenalng.com/Pages/default.aspx','http://www.stenabulk.com/sites/all/themes/stenabulk/assets/img/stena_white.png','Shipping'),
        (NULL ,'Liquiline','59.313203','18.181647','The company is regarded a specialist in the transport and storage of liquefied natural gas (LNG) and liquefied biogas (LBG). Liquiline delivers Front-End Engineering & Design (FEED) and Project Management services for an LNG-terminal','http://www.liquiline.com/','http://www.liquiline.com/publish_skins/liquiline_old/img/logo.72.png','Shipping'),
        (NULL ,'Skangass AS','57.706873','11.940639','Skangass AS was established in 2007 and is owned by Lyse Group Skangass will be responsible for the operation of the LNG plant at Risavika in Sola. The plant will have an annual production of 300,000 tonnes of LNG, equivalent to the energy consumption of two cities the size of Stavanger.','http://www.skangass.com/','http://www.turkishmaritime.com.tr/d/news/17558.jpg','end-user technologies'),
        (NULL ,'Frederiet AB','59.237941','18.517178','Frederiet AB has for several years studied and analysed the development of the supply chain for LNG and other alternative ship fuels and has indentified it as an interesting growth area and a complement to the present shipping activities in Frederiet AB. White Smoke AB and Frederiet AB have decided to join forces in the development of the world’s first LNG bunker vessel operation.','','http://donsoshippingmeet.com/assets/2016/10/frederiet_ny-600x400.png','Bunkering'),
        (NULL ,'E.ON - Karlshamnkraft','56.163923','14.859039','E.ON Nordic is large provider and distributor of LNG. Mid Sweden Project •Market Potential 15-25 TWh in 1st Phase •600 km High Pressure Pipeline •First Deliveries in 2010 •Main Supply Option: LNG •Many supply options have been underconsideration over the years: •Extension of Grid from the South, severalroutes considered •Pipeline from Russia, Norway, Finland, Germany','http://www.karlshamnkraft.se','https://www.uniper.energy/sverige/themes/custom/uniper/images/uniper-logo-large.gif','end-user technologies'),
        (NULL ,'Preem AB','59.339321','18.011455','Preem AB advise a new LNG plant will be built at Brofjorden in order to supply refinery with abt 250,000 t liquid natural gas. The LNG will substitute naphtha and butane in the process and are expected to reduce the refinerys carbon dioxide emissions by abt 100,000 t yearly. Preem expect facility to be up and running end of 2013.','http://www.preem.se','http://www.preem.se/assets/images/general/logotype80px.png','end-user technologies'),
        (NULL ,'FKAB Marine Design','58.351105','11.927191','FKAB is an independent Marine Engineering Company, mainly active in the Marine and Shipbuilding Industry. We work internationally with offices in both Sweden and China.','http://www.fkab.com/','http://fkab.com/wp-content/uploads/sites/3/FKAB-Logo-Little-White.png','Shipbuilding & Repair'),
        (NULL ,'Svenska Kraftnät','57.701189','11.946314','Svenska Kraftnät (Swedish national grid) is a state-owned public utility that has many different areas of work. One of Svenska Kraftnät’s important tasks is to transmit electricity from the major power stations to regional electrical grids, via the national electrical grid.In our control room, we monitor the national electrical and gas grids and ensure that there is always a balance between consumption and production in Sweden. Our work contributes to ensuring an electricity market where the players can purchase electricity in free competition.We are the government authority responsible for electricity preparedness and we work to reinforce the country’s electricity supply system to ensure it is able to withstand critical situations. We are also responsible for the natural gas system in Sweden, and we coordinate the country’s dam safety.','www.svk.se','https://upload.wikimedia.org/wikipedia/en/thumb/9/9e/Svenska_kraftn%C3%A4t_logo.svg/800px-Svenska_kraftn%C3%A4t_logo.svg.png','end-user technologies'),
        (NULL ,'Öresundskraft AB','56.031401','12.703861','Öresundskraft sells customer-focused energy solutions and supply safe distribution. Bringing to the Öresund region confidence through employee customer, environment and community involvement.','http://www.oresundskraft.se','http://www.oresundskraft.se/styles/img/graphics/oresundskraft-logo.png','end-user technologies'),
        (NULL ,'Stockholms Gas','57.701189','11.946314','To offer our customers a safe gas, while contributing to a greener Stockholm is our primary mission. We have two separate gas networks. A gas is 60 mil long and contains the city gas. As early as 1853 city gas was introduced in Stockholm for the first time. Town gas is a part of Stockholm\'s history and some of Stockholm\'s future.The second gas grid is 4 mil and just recently built and includes vehicle. Vehicle reduce traffic emissions.','http://www.stockholmgas.se/','http://www.stockholmgas.se/wp-content/themes/stockholmgas/img/logo.svg','end-user technologies'),
        (NULL ,'Göteborg Energi AB','57.7105','11.997423','Offer sustainable energy solutions for electricity, heating and gas.','http://www.goteborgenergi.se/','http://resources.mynewsdesk.com/image/upload/t_open_graph_image/deisjix0lmspcfr9k7sm.jpg','end-user technologies'),
        (NULL ,'Samson AB','57.561543','11.96052','is the worlds largest family owned control valve manufacturer. A synonym for high-quality work, entrepreneurial spirit and innovative strength since 1907. The company is not only known for a complete product line in instrumentation and controls, but also offers the most modern integrated automation systems. The field of expertise extends through Oil & Gas, Refinery, Petro-chemical, Chemical plants , Power Generation, Pulp & Paper, Pharmaceutical, Food & Beverage and Heating Ventilation and Air-conditioning (HVAC) applications. SAMSON deliver valves and equipment to cryo and LNG applications for both land and offshore installations.','http://www.samsongroup.eu','http://www.samson.se/images/header_index_en.gif','end-user technologies'),
        (NULL ,'Lunds EnergiKonecernen AB','55.715097','13.219471','Lunds Energi Group AB (publ) is the parent company of a number of smaller companies and aims to provide service and support to operational activities. The Group\'s activities cover the generation, distribution and sale of electricity, gas, heating and cooling, and energy-related services within the service, services and contracts.The focus of activities in southwest Skåne, Lund and Lomma and Eslöv and Hörby in Ringsjö area. The Group is also firmly established in northwest Skåne, Blekinge, Smaland, Södermanland, Sjuhäradsbygden and Västgötaslätten plains.The local support is a key element of the Group\'s strategy. Each local company has a local sales department, locally stationed service and community-based boards with at least two representatives from the municipality or the local business community.','http://www.lundsenergikoncernen.se/','https://www.kraftringen.se/globalassets/global/kraftringen/kraftringen_logotyp.png','end-user technologies'),
        (NULL ,'KONECRANES LIFTTRUCKS AB','56.346233','13.661625','Lonecranes is a world-leading group of Lifting Businesses™, serving a broad range of customers, including manufacturing and process industries, shipyards, ports and terminals. Regardless of your lifting needs, Konecranes is committed to providing you with lifting equipment and services that increase the value and effectiveness of your business.','http://www.konecraneslifttrucks.se/','http://www.konecranes.com/sites/all/themes/konecranes/logo.png','Shipping'),
        (NULL ,'Cargotec','56.827391','13.434722','Serving a broad range of customers, including manufacturing and process industries, shipyards, ports and terminals. Regardless of your lifting needs, Konecranes is committed to providing you with lifting equipment and services that increase the value and effectiveness of your business.','http://www.cargotec.com/en-global/Pages/default.aspx','https://www.cargotec.com/Static/img/cargotec-logo.svg','end-user technologies'),
        (NULL ,'Mann-Teknik AB','58.713521','13.828542','A coupling manufacturer Mann Tek is a coupling manufacturer. Mann Tek produces and markets products for safe and environmentally friendly handling of aggressive fluids for the chemical and petrochemical industries.','http://www.mann-tek.com/','https://yt3.ggpht.com/a-/AJLlDp14CQof3WvZmMWRWpkvBukfqjqynibuG4th2w=s900-mo-c-c0xffffffff-rj-k-no','end-user technologies'),
        (NULL ,'Swedish Gas Association','59.182823','17.633607','The Swedish Gas Association is a member-funded, industry association dedicated to promoting a greater use of these gases for energy. The association works towards a safe, environmentally responsible and efficient utilization of gas and acts as a voice for all gases where safety, technical matters, marketing and advocacy are key elements. The association also promotes R&D within the sector through its shares in the Swedish Gas Centre, SGC, where some bigger gas companies are the other share holders. The assignment of SGC is to co-ordinate Swedish industrial interest in R&D concerning gas fuel technology.','http://www.energigas.se/In-English','https://7c1096715b08106e45d9-86066560621c8d09273ccd7d125f633d.ssl.cf5.rackcdn.com/r/logos/85041/energigas.png','Research'),
        (NULL ,'Stockholm liquefied Methane gas station','59.32893','18.06491','','','https://7c1096715b08106e45d9-86066560621c8d09273ccd7d125f633d.ssl.cf5.rackcdn.com/r/logos/85041/energigas.png','end-user technologies'),
        (NULL ,'Enagas S.A','40.40357','-3.710346','Enagas, carrier and System Technical Manager, guarantees the continuity and security of natural gas supply.','http://www.enagas.es','https://i.forbesimg.com/media/lists/companies/enagas_416x416.jpg','end-user technologies'),
        (NULL ,'Gothenburg Port','57.70887','11.97456','The Port of Gothenburg is the largest port in the Nordic region with 11,000 visits by vessels each year. One-third of Swedish foreign trade passes through the Port of Gothenburg as well as 60 per cent of all container traffic. The Port of Gothenburg is the only port in Sweden with the capacity to receive the world\'s largest container vessels and has the broadest range of shipping routes within and outside Europe. The 25 rail shuttles that depart each day mean that companies throughout Sweden and Norway have a direct, environmentally smart link to the largest port in the Nordic region. The Port of Gothenburg has terminals for oil, cars, ro-ro, containers and passengers.','http://www.portofgothenburg.com/','https://www.portofgothenburg.com/globalassets/logo.png?preset=logo','Ports'),
        (NULL ,'Nynäshamn port','58.905547','17.955489','','www.stoports.com','https://www.crwflags.com/fotw/images/s/se~sh.gif','Ports'),
        (NULL ,'Port of Copenhagen & Malmö','55.620627','13.00378','','www.cmport.com','http://www.cmport.com/images/ISO_9001_ISO_14001.png','Ports'),
        (NULL, 'Chalmers University','57.566028','11.247246','Chalmers and the Swedish Maritime Administration are creating a state of the art simulator centre for future research and education.','http://www.chalmers.se/en/departments/smt/news/Pages/Chalmers-and-the-Swedish-Maritime-Administration-creates-new-simulator-centre.aspx','http://www.chalmers.se/_layouts/ChalmersPublicWeb/images/topmenu-logo.png','Education'),
        (NULL ,'Swedish Maritime Administration','58.583034','16.190782','he Swedish Maritime Administration (SMA) offers modern and safe shipping routes with 24 hour service. We take responsibility for the future of shipping. SMA is a governmental agency and enterprise within the transport sector and is responsible for maritime safety and availability.','http://www.sjofartsverket.se/en','http://www.sjofartsverket.se/templates/main/styles/newimages/sfvlogo.png','Research'),
        (NULL ,'Alfa Laval','55.72379','13.156087','Creating the best heat transfer, separation and fluid handling technologies in the world for more than 125 years, Alfa Laval\'s products and solutions are used in such areas as food and water supply, energy, environmental protection and pharmaceuticals.','www.alfalaval.com','https://www.alfalaval.com/ui/css/img/logo-alfalaval.png','end-user technologies'),
        (NULL ,'Royal Vopak','51.905381','4.474401','Vopak Sweden is the leading operator of independent tankstorage facilities in the Nordic countries. We are part of the Royal Vopak network which consists of more than 70 tank terminals in around 30 countries. Our connection to this international network allows us to provide you with the highest standards in safety and service on the Scandinavian market as to liquid bulk logistics. Through fully owned and independently operated terminals in Gothenburg, Malmo, Sodertalje and Gavle, we offer a full range of tankstorage services for petroleum products, chemicals and bitumen.','http://www.vopak.com/','https://www.vopak.com/sites/all/themes/vopak/logo.png','Storage'),
        (NULL ,'Wayne','59.34786','18.023723','Wayne, A GE Energy Business and a global innovator of fuel dispensers and forecourt technologies, announced today that it has relocated the company\'s production of compressed natural gas (CNG) dispensers manufacturing operation from Talmona, Italy to Malmö, Sweden.','http://www.wayne.com/','https://www.wayne.com/media/1578/waynefuelingsystems_logo.svg','end-user technologies'),
        (NULL ,'SSPA Sweden AB','57.689202','11.97643','Effective transport solutions, low fuel consumption, clean and vital coastal zones! At SSPA we supply attractive solutions for our customers, today and for the future. We create profit for our customers though sustainable, innovative, and world leading maritime solutions','http://www.sspa.se/','http://www.sspa.se/sites/www.sspa.se/themes/sspa/logo.png','Bunkering'),
        (NULL ,'ÅF AB','55.614322','12.98961','The ÅF Group is a leader in technical consulting, with expertise founded on more than a century of experience. We offer highly qualified services and solutions for industrial processes, infrastructure projects and the development of products and IT systems. Today the ÅF Group has approx. 5,000 employees. Our base is in Europe, but our business and our clients are found all over the world.','http://www.afconsult.com/','http://www.afconsult.com/Assets/Images/svg/af-logo-tag-left.svg','Bunkering'),
        (NULL ,'Swedish Marine Technology Forum','58.349201','11.926198','Swedish Marine Technology Forum is a non-profit organization that gathers the maritime industry in Sweden.The organization is working toward development of new and less environmentally damaging products, efficient production and cooperation between firms, universities and public representatives. Swedish Marine Technology Forum is also working to increase recruitment and enhance regeneration in the maritime industry. The forum brings together the entire maritime industry in Sweden and its future challenges. The forum is addressed to the companies that is suppliers for the shipping, offshore and the leisure boat industry. Our members are engineering solutions, manufacturing, products and services in these areas.','http://www.smtf.se/en/start.html','http://smtf.se/wp-content/uploads/2013/08/copy-cropped-logo.png','Shipping'),
        (NULL ,'World Maritime University, Malmö','55.605226','12.98073','Founded by the International Maritime Organization \(IMO\), a specialized agency of the United Nations, WMU is a center of excellence for maritime post-graduate education and research. WMU offers M.Sc. and Ph.D. programs as well as Professional Development Courses with the highest standards in maritime affairs. Headquartered in Malmö, Sweden with additional M.Sc. programs in Shanghai and Dalian, China,  WMU promotes the international exchange and transfer of maritime ideas and knowledge.','http://wmu.se/','http://wmu.se/sites/all/themes/wmu_locke/logo.png','Education')";
        

if($connection->query($sql) === TRUE){
  echo " company INSERTED successfully!" . "</br>";
}else {
  echo "Error INSERTING company DATA!" . $connection->error . "</br>" ;
}

$sql = "CREATE TABLE relationship (
id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
company_start int NOT NULL,
company_end int NOT NULL,
description VARCHAR(255) NOT NULL,
adder int NOT NULL
)ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci";

if ($connection->query($sql) === true) {
    echo "company relationship table created successfully" . "</br>";
} else {
    echo "Error in creating relationship company table " . $connection->error . "</br>";
}

//Here add userinfo
$sql = "INSERT INTO relationship (id, company_start, company_end, description,adder)
        VALUES
        (null, '32', '1', 'This company provides services for us!','32'),
        (null, '32', '3', 'This company provides services for us!','32'),
        (null, '39', '32', 'This company provides services for us!','32'),
        (null, '39', '32', 'This company provides services for us!','39'),
        (null, '33', '21', 'This company provides services for us!','33')";

if($connection->query($sql) === TRUE){
    echo " relationship INSERTED successfully!" . "</br>";
}else {
    echo "Error INSERTING relationship DATA!" . $connection->error . "</br>" ;
}

?> 


