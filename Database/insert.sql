USE ecommerce;

DELETE FROM categoriaProdotti;
INSERT INTO categoriaProdotti
VALUES
(1, "Scheda Madre"),
(2, "Processore"),
(3, "RAM"),
(4, "HD"),
(5, "SSD"),
(6, "Case"),
(7,'Schermi');

DELETE FROM permesso;
INSERT INTO permesso
VALUES
(1, "Utente"),
(2, "Amministratore");

DELETE FROM tipoCarta;
INSERT INTO tipoCarta
VALUES
(1, "Visa"),
(2, "MasterCard");

DELETE FROM utente;
INSERT INTO utente
VALUES
('1', 'Davide', 'Lavalle', '1996-08-04', '123davide098', 'davide.lavalle.45@gmail.com', '2', 'domanda', 'risposta', '0');

DELETE FROM corriere;
INSERT INTO corriere
VALUES
(1, 'TNT', 30),
(2, 'DHL', 40),
(3, 'UPS', 25);

INSERT INTO `prodotto`
VALUES 
(1,'Samsung SSD 250',5,234,'2','SATA III, 250 GB, 2.5GHz.',1),
(2,'Schermo curvo LCD LG',7,150,'4','Schermo LCD 21:9 FULL HD',1),
(3,'Case figo',6,100,'1','Case molto figo ',1),
(4,'Processore intel',2,220,'2','Processore Intel',1),
(5,'Samsung EVO860',5,250,'2','Samsung EVO 860, colore nero, Compatibile SATA III, Supporto alla velocità della luce',1),
(6,'SSD SanDisk',5,680,'1','SSD sandisk, 500GB',1),
(7,'SSD Intel',5,290,'3','SSD intel molto bello.',1),
(8,'SSD crucial',5,120,'3','SSD Crucial nuovo.',1),
(9,'RAM corsair',3,234,'2','Corsair 16GB Vengeance LPX DDR4 2400MHz RAM/Memory Kit ',1),
(10,'Ram Viper',3,236,'1','RAM rosse veloci.',1),
(11,'Schermo Dell',7,345,'2','schermi 5K che hanno un prezzo di 2500 dollari. ',1),
(12,'Scheda Madre',1,300,'2','Scheda madre figa',1);