/* Drop tables */
drop table if exists users;
drop table if exists departments;
drop table if exists tickets;
drop table if exists faqs;
drop table if exists ticket_changes;


/* Creating tables */
create table users (
     id integer primary key,
     name text not null,
     username text not null unique,
     password text not null,
     email text not null unique,
     is_admin integer not null default 0,
     is_agent integer not null default 0,
     department_id integer,
     foreign key (department_id) references departments (id)
);

create table departments (
     id integer primary key,
     name text not null unique,
     image_path text,
     description text
);

create table tickets (
     id integer primary key,
     title text not null,
     description text not null,
     status integer not null default 0,
     priority integer not null default 0,
     department_id integer,
     client_id integer not null,
     agent_id integer,
     tags text not null,
     foreign key (department_id) references departments (id),
     foreign key (client_id) references users (id),
     foreign key (agent_id) references users (id)
);

create table faqs (
     id integer primary key,
     question text not null unique,
     answer text not null
);

create table ticket_changes (
     id integer primary key,
     ticket_id integer not null,
     user_id integer not null,
     status integer not null,
     department_id integer,
     hashtags text,
     comment text,
     faq_id integer,
     timestamp DATETIME not null default CURRENT_TIMESTAMP,
     foreign key (ticket_id) references tickets (id),
     foreign key (user_id) references users (id),
     foreign key (department_id) references departments (id),
     foreign key (faq_id) references faqs (id)
);

/* Inserts */
insert into users (id, name, username, password, email, is_admin, is_agent, department_id) values
(1, 'John Smith', 'johnsmith', '1234', 'john.smith@example.com', 1, 1, 1),
(2, 'Emily Brown', 'emilybrown', '1234', 'emily.brown@example.com', 1, 1, 1),
(3, 'Michael Johnson', 'michaeljohnson', '1234', 'michael.johnson@example.com', 1, 1, 2),
(4, 'Jessica Davis', 'jessicadavis', '1234', 'jessica.davis@example.com', 0, 0, NULL),
(5, 'William Wilson', 'williamwilson', '1234', 'william.wilson@example.com', 0, 0, NULL),
(6, 'Samantha Taylor', 'samanthataylor', '1234', 'samantha.taylor@example.com', 0, 0, NULL),
(7, 'Benjamin Lee', 'benjaminlee', '1234', 'benjamin.lee@example.com', 0, 0, NULL),
(8, 'Elizabeth Rodriguez', 'elizabethrodriguez', '1234', 'elizabeth.rodriguez@example.com', 0, 0, NULL),
(9, 'Christopher Martinez', 'christophermartinez', '1234', 'christopher.martinez@example.com', 0, 0, NULL),
(10, 'Amanda Hernandez', 'amandahernandez', '1234', 'amanda.hernandez@example.com', 0, 0, NULL),
(11, 'David Brown', 'davidbrown', '1234', 'david.brown@example.com', 0, 0, NULL),
(12, 'Melissa Gonzalez', 'melissagonzalez', '1234', 'melissa.gonzalez@example.com', 0, 0, NULL),
(13, 'Matthew Hernandez', 'matthewhernandez', '1234', 'matthew.hernandez@example.com', 0, 0, NULL),
(14, 'Ashley Perez', 'ashleyperez', '1234', 'ashley.perez@example.com', 0, 0, NULL),
(15, 'Daniel Turner', 'danielturner', '1234', 'daniel.turner@example.com', 0, 0, NULL),
(16, 'Jennifer Carter', 'jennifercarter', '1234', 'jennifer.carter@example.com', 0, 0, NULL),
(17, 'Joseph Collins', 'josephcollins', '1234', 'joseph.collins@example.com', 0, 0, NULL),
(18, 'Lauren Richardson', 'laurenrichardson', '1234', 'lauren.richardson@example.com', 0, 0, NULL),
(19, 'Anthony King', 'anthonyking', '1234', 'anthony.king@example.com', 0, 1, 4),
(20, 'Michelle Scott', 'michellescott', '1234', 'michelle.scott@example.com', 0, 1, 6),
(21, 'Brian Green', 'briangreen', '1234', 'brian.green@example.com', 0, 1, 6),
(22, 'Stephanie Baker', 'stephaniebaker', '1234', 'stephanie.baker@example.com', 0, 1, 6),
(23, 'Kevin Adams', 'kevinadams', '1234', 'kevin.adams@example.com', 0, 1, 6),
(24, 'Rachel Mitchell', 'rachelmitchell', '1234', 'rachel.mitchell@example.com', 0, 1, 8),
(25, 'Timothy Campbell', 'timothycampbell', '1234', 'timothy.campbell@example.com', 0, 1, 10),
(26, 'Nicole Turner', 'nicoleturner', '1234', 'nicole.turner@example.com', 0, 0, NULL),
(27, 'Andrew Hill', 'andrewhill', '1234', 'andrew.hill@example.com', 0, 0, NULL),
(28, 'Kayla Mitchell', 'kaylamitchell', '1234', 'kayla.mitchell@example.com', 0, 0, NULL),
(29, 'Brandon Cook', 'brandoncook', '1234', 'brandon.cook@example.com', 0, 0, NULL),
(30, 'Olivia Ward', 'oliviaward', '1234', 'olivia.ward@example.com', 0, 0, NULL),
(31, 'Daniel Baker', 'danielbaker', '1234', 'daniel.baker@example.com', 0, 0, NULL),
(32, 'Megan Reed', 'meganreed', '1234', 'megan.reed@example.com', 0, 0, NULL),
(33, 'Jacob Martinez', 'jacobmartinez', '1234', 'jacob.martinez@example.com', 0, 0, NULL),
(34, 'Natalie Morris', 'nataliemorris', '1234', 'natalie.morris@example.com', 0, 0, NULL),
(35, 'Ryan Hill', 'ryanhill', '1234', 'ryan.hill@example.com', 0, 0, NULL),
(36, 'Victoria Lopez', 'victorialopez', '1234', 'victoria.lopez@example.com', 0, 0, NULL),
(37, 'William Jenkins', 'williamjenkins', '1234', 'william.jenkins@example.com', 0, 0, NULL),
(38, 'Gabriella Ramirez', 'gabriellaramirez', '1234', 'gabriella.ramirez@example.com', 0, 0, NULL),
(39, 'Jackson Anderson', 'jacksonanderson', '1234', 'jackson.anderson@example.com', 0, 0, NULL),
(40, 'Sophia Hughes', 'sophiahughes', '1234', 'sophia.hughes@example.com', 0, 0, NULL),
(41, 'Ethan Clark', 'ethanclark', '1234', 'ethan.clark@example.com', 0, 0, NULL),
(42, 'Ava Adams', 'avaadams', '1234', 'ava.adams@example.com', 0, 0, NULL),
(43, 'Noah Lewis', 'noahlewis', '1234', 'noah.lewis@example.com', 0, 0, NULL),
(44, 'Chloe Turner', 'chloeturner', '1234', 'chloe.turner@example.com', 0, 0, NULL),
(45, 'Liam Peterson', 'liampeterson', '1234', 'liam.peterson@example.com', 0, 0, NULL),
(46, 'Abigail Griffin', 'abigailgriffin', '1234', 'abigail.griffin@example.com', 0, 0, NULL),
(47, 'James Rodriguez', 'jamesrodriguez', '1234', 'james.rodriguez@example.com', 0, 1, 4),
(48, 'Grace Evans', 'graceevans', '1234', 'grace.evans@example.com', 0, 1, 6),
(49, 'Alexander Johnson', 'alexanderjohnson', '1234', 'alexander.johnson@example.com', 0, 1, 6),
(50, 'Lily Thompson', 'lilythompson', '1234', 'lily.thompson@example.com', 0, 1, 6),
(51, 'Daniel Adams', 'danieladams', '1234', 'daniel.adams@example.com', 0, 1, 6),
(52, 'Zoe Walker', 'zoewalker', '1234', 'zoe.walker@example.com', 0, 1, 8),
(53, 'Michael James', 'michaeljames', '1234', 'michael.james@example.com', 0, 1, 10);


insert into departments (id, name, image_path, description) values
(1, 'Software Development', '../docs/software_development.jpg', 'The Software Development department is responsible for designing, coding, testing, and maintaining software applications.'),
(2, 'Quality Assurance', '../docs/quality_assurance.jpg', 'The Quality Assurance department ensures that software and systems meet the required standards and specifications by conducting thorough testing and quality control.'),
(3, 'IT Operations', '../docs/it_operations.jpg', 'The IT Operations department manages and maintains the organizations IT infrastructure, including hardware, networks, servers, and systems.'),
(4, 'Database Administration', '../docs/database_management.jpg', 'The Database Administration department handles the design, implementation, and maintenance of the organizations databases, ensuring data integrity, security, and performance.'),
(5, 'Cybersecurity', '../docs/cybersecurity.jpg', 'The Cybersecurity department safeguards the organizations systems and networks from potential threats, implementing security measures, and responding to security incidents.'),
(6, 'Project Management', '../docs/project_management.jpg', 'The Project Management department oversees the planning, execution, and successful completion of projects, ensuring they are delivered within scope, on time, and within budget.'),
(7, 'Data Analytics', '../docs/data_analytics.jpg', 'The Data Analytics department analyzes and interprets data to provide insights and support data-driven decision-making within the organization.'),
(8, 'UI/UX Design', '../docs/uiux_design.jpg', 'The UI/UX Design department focuses on creating user-friendly and visually appealing interfaces for software applications, websites, and other digital products.'),
(9, 'Technical Writing', '../docs/technical_writing.jpg', 'The Technical Writing department produces clear and concise documentation, user guides, and manuals to assist users in understanding and utilizing the organizations products and services.'),
(10, 'Technical Support', '../docs/technical_support.jpg', 'The Technical Support department provides assistance and troubleshooting for customers or internal users, helping them resolve technical issues and inquiries.');

INSERT INTO tickets (id, title, description, status, priority, department_id, client_id, agent_id, tags) VALUES
(1, 'Can''t login to my account', 'I''m unable to login to my account even though I''m using the correct credentials. Please help!', 1, 3, 3, 4, 19, '#login #error #help'),
(2, 'Error message when accessing website', 'Every time I try to access the website, I get an error message. Can you please fix this?', 2, 7, 1, 5, 20, '#website #error #help'),
(3, 'Software installation issue', 'I''m trying to install the software on my computer, but I keep getting an error. Can you please assist me with this?', 0, 9, 1, 6, 21, '#software #installation #issue'),
(4, 'Slow network speed', 'I''ve noticed that the network speed has been very slow lately. Can you please look into this?', 1, 2, 3, 7, 22, '#network #speed #slow'),
(5, 'Email delivery delay', 'I sent an important email yesterday, but the recipient hasn''t received it yet. Can you please check what''s causing the delay?', 0, 5, 7, 8, 23, '#email #delivery #delay'),
(6, 'Data loss after system crash', 'My computer crashed yesterday and now I can''t find some of my files. Is there any way to recover them?', 2, 1, 4, 9, 24, '#data #loss #system #crash'),
(7, 'Website design feedback', 'I''m not very happy with the design of the website. Can you please pass along some feedback to the design team?', 0, 4, 8, 10, NULL, '#website #design #feedback'),
(8, 'Login page needs improvement', 'The login page of the website is very confusing. Can you please make some improvements to it?', 1, 8, 2, 11, 19, '#login #page #improvement'),
(9, 'Account information update', 'I need to update some information on my account, but I can''t find the option to do so. Can you please guide me through the process?', 2, 0, 6, 12, 20, '#account #information #update'),
(10, 'Payment issue', 'I tried to make a payment, but it didn''t go through. Can you please help me resolve this issue?', 1, 1, 9, 13, 21, '#payment #issue'),
(11, 'Unable to login', 'I am unable to login to my account', 1, 6, 3, 4, 23, '#login #issue'),
(12, 'Broken link on website', 'I found a broken link on your website while browsing', 0, 2, 8, 9, 20, '#website #broken #link'),
(13, 'Slow website performance', 'The website is loading very slow and takes forever to navigate', 2, 9, 1, 12, NULL, '#website #performance #slow'),
(14, 'Inaccurate billing', 'I was billed for services that I did not receive', 1, 4, 7, 16, 23, '#billing #inaccurate'),
(15, 'Error in application', 'I am receiving an error message when using your application', 0, 7, 2, 14, 21, '#application #error'),
(16, 'Missing data', 'Data is missing from my account and I need it for my records', 2, 1, 6, 13, 19, '#missing #data'),
(17, 'Software crash', 'The software crashed while I was using it and I lost my work', 1, 3, 1, 7, 22, '#software #crash'),
(18, 'Security breach', 'I think my account has been compromised and someone accessed it without my permission', 2, 8, 5, 2, 25, '#security #breach'),
(19, 'New feature request', 'I would like to request a new feature for your software', 0, 0, 3, 18, 21, '#feature #request'),
(20, 'Unable to upload files', 'I am unable to upload files to my account', 1, 5, 4, 11, 23, '#upload #files #issue'),
(21, 'Issue with database connection', 'Unable to connect to database server. Getting a connection refused error.', 1, 4, 4, 5, 19, '#database #connection #issue'),
(22, 'Error when running software update', 'Getting a "cannot find update package" error when trying to run the software update', 0, 6, 1, 4, NULL, '#software #update #error'),
(23, 'UI issue with login page', 'The login button is not displaying correctly on the login page. It is cut off at the bottom.', 1, 3, 8, 9, 21, '#login #page #ui #issue'),
(24, 'Application crashing on startup', 'The application crashes immediately upon startup with no error message', 2, 9, 1, 6, 19, '#application #crash #startup'),
(25, 'Report not generating correctly', 'When trying to generate a report, the data is not displaying correctly. Some rows are missing and some columns are not displaying the correct data.', 1, 1, 7, 15, 23, '#report #generation #issue'),
(26, 'Unable to print from application', 'Clicking the "Print" button in the application does not bring up the print dialog. Nothing happens.', 0, 5, 1, 4, NULL, '#print #application #issue'),
(27, 'Issue with email notifications', 'Email notifications are not being sent when a new ticket is created or when a ticket is updated.', 1, 2, 3, 10, 20, '#email #notifications #issue'),
(28, 'Incorrect data being displayed', 'On the user profile page, some of the data being displayed is incorrect. The email address is not displaying correctly and the user''s phone number is missing.', 2, 7, 6, 8, 22, '#data #display #incorrect'),
(29, 'Error message when saving file', 'When trying to save a file in the application, an error message appears stating "Access denied".', 0, 2, 1, 5, NULL, '#file #save #error'),
(30, 'Application freezing when loading large dataset', 'When trying to load a large dataset, the application freezes and becomes unresponsive.', 1, 8, 7, 12, 25, '#application #freeze #dataset'),
(31, 'Website loading issue', 'The website is taking a long time to load. Its been happening for a couple of days now.', 0, 4, 1, 5, NULL, '#website #loading #issue'),
(32, 'Email configuration problem', 'Im having trouble configuring my email account on Outlook. It keeps showing an error.', 1, 3, 7, 8, 24, '#email #configuration #problem'),
(33, 'Database connection error', 'Im unable to establish a connection to the database. Can you please assist?', 1, 2, 4, 9, 51, '#database #connection #error'),
(34, 'Forgot password', 'I forgot my password and Im unable to reset it. Can you please help?', 2, 6, 3, 4, 51, '#forgot #password #reset'),
(35, 'Software bug', 'Ive encountered a bug in the software. It crashes whenever I try to perform a specific action.', 0, 5, 1, 7, 53, '#software #bug #crash'),
(36, 'Network outage', 'There is a complete network outage in our office. We are unable to access any online services.', 1, 1, 3, 12, NULL, '#network #outage'),
(37, 'Incorrect invoice amount', 'I received an invoice with an incorrect amount. The total doesnt match the agreed-upon price.', 2, 0, 7, 16, 49, '#invoice #amount #incorrect'),
(38, 'Application not responding', 'The application is not responding when I try to open it. Ive tried restarting my computer, but the issue persists.', 1, 4, 2, 14, 48, '#application #not #responding'),
(39, 'Data import problem', 'Im having trouble importing a large dataset into the system. It keeps failing halfway through the process.', 0, 9, 4, 19, 52, '#data #import #problem'),
(40, 'Website layout issue', 'The website layout is broken in certain browsers. It doesnt display correctly.', 2, 1, 8, 10, NULL, '#website #layout #issue');


INSERT INTO faqs (id, question, answer) VALUES 
(1, 'What is a computer virus?', 'A computer virus is a type of malicious software that can replicate itself and spread to other computers or devices.'),
(2, 'What is phishing?', 'Phishing is a fraudulent attempt to obtain sensitive information, such as usernames, passwords, and credit card details, by disguising oneself as a trustworthy entity in an electronic communication.'),
(3, 'What is encryption?', 'Encryption is the process of converting plain text into coded language to protect sensitive information from unauthorized access.'),
(4, 'What is a firewall?', 'A firewall is a network security system that monitors and controls incoming and outgoing network traffic based on predetermined security rules.'),
(5, 'What is a router?', 'A router is a networking device that forwards data packets between computer networks.'),
(6, 'What is a server?', 'A server is a computer program or device that provides functionality to other programs or devices, called clients.'),
(7, 'What is cloud computing?', 'Cloud computing is the delivery of computing services—including servers, storage, databases, networking, software, analytics, and intelligence—over the Internet ("the cloud") to offer faster innovation, flexible resources, and economies of scale.'),
(8, 'What is a backup?', 'A backup is a copy of computer data taken and stored elsewhere so that it may be used to restore the original after a data loss event.'),
(9, 'What is malware?', 'Malware is a type of software that is designed to cause harm to computer systems, networks, or devices.'),
(10, 'What is a LAN?', 'A LAN, or local area network, is a computer network that spans a relatively small area, typically within a single building or group of buildings.'),
(11, 'What is a WAN?', 'A WAN, or wide area network, is a computer network that spans a large geographic area and typically uses leased telecommunications circuits.'),
(12, 'What is a VPN?', 'A VPN, or virtual private network, is a secure and encrypted connection between two or more devices over the Internet.'),
(13, 'What is a browser?', 'A browser is a software application used to access and view websites and other online content on the Internet.'),
(14, 'What is a search engine?', 'A search engine is a software program that searches a database of Internet sites and returns a list of sites that match the search criteria.'),
(15, 'What is a cookie?', 'A cookie is a small file that a website stores on a user''s computer or device to remember certain information about the user and their preferences.'),
(16, 'What is two-factor authentication?', 'Two-factor authentication (2FA) is a security measure that requires users to provide two different forms of identification to verify their identity, usually a combination of something they know (e.g., password) and something they possess (e.g., a security token or mobile device).'),
(17, 'What is a data breach?', 'A data breach refers to an unauthorized access, disclosure, or acquisition of sensitive information, such as personal data or trade secrets, by an individual, group, or entity.'),
(18, 'What is social engineering?', 'Social engineering is a tactic used by attackers to manipulate and deceive individuals into divulging confidential information or performing actions that may compromise security.'),
(19, 'What is a denial-of-service (DoS) attack?', 'A denial-of-service (DoS) attack is an attempt to make a computer or network resource unavailable to its intended users by overwhelming it with a flood of illegitimate requests or by exploiting vulnerabilities to cause a system crash.'),
(20, 'What is biometric authentication?', 'Biometric authentication uses unique physical or behavioral traits, such as fingerprints, facial features, or voice patterns, to verify a person''s identity.'),
(21, 'What is data encryption at rest?', 'Data encryption at rest refers to the process of encrypting data stored in persistent storage, such as hard drives or databases, to protect it from unauthorized access in case the storage medium is compromised.'),
(22, 'What is a distributed denial-of-service (DDoS) attack?', 'A distributed denial-of-service (DDoS) attack is similar to a DoS attack but involves multiple compromised computers, known as a botnet, to simultaneously flood the target system with a massive volume of requests.'),
(23, 'What is a vulnerability?', 'A vulnerability is a weakness or flaw in a system or software that can be exploited by attackers to gain unauthorized access, disrupt services, or compromise the integrity of the system.'),
(24, 'What is multi-factor authentication?', 'Multi-factor authentication (MFA) is a security method that requires users to provide two or more independent forms of identification to verify their identity, adding an extra layer of protection.'),
(25, 'What is a patch?', 'A patch is a software update released by developers to fix security vulnerabilities or improve the functionality of an application or operating system.'),
(26, 'What is data privacy?', 'Data privacy refers to the protection and proper handling of sensitive information, ensuring that individuals have control over their personal data and that it is not misused or accessed without their consent.'),
(27, 'What is a vulnerability scan?', 'A vulnerability scan is an automated process that identifies security weaknesses or vulnerabilities in a system or network, providing insights for remediation and proactive security measures.'),
(28, 'What is a cyber attack?', 'A cyber attack is an offensive action targeting computer systems, networks, or devices, with the intent to compromise security, steal data, or disrupt normal operations.'),
(29, 'What is a brute-force attack?', 'A brute-force attack is a trial-and-error method used by attackers to guess passwords or encryption keys by systematically trying all possible combinations until the correct one is found.'),
(30, 'What is data backup and recovery?', 'Data backup and recovery is the process of creating copies of important data and implementing strategies to restore it in case of data loss or system failure.');
