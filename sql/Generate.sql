Drop table Caracteristici CASCADE CONSTRAINTS PURGE;
Drop table Artefact CASCADE CONSTRAINTS PURGE;
Drop table Arheolog CASCADE CONSTRAINTS PURGE;
Drop table Detinator CASCADE CONSTRAINTS PURGE;
Drop table Locatie CASCADE CONSTRAINTS PURGE;
Drop table Tipologie CASCADE CONSTRAINTS PURGE;
Drop table Incadrare CASCADE CONSTRAINTS PURGE;
Drop table Admin;


Create Table Artefact (ID number(10),Nume varchar2(255) NOT NULL,ID_Arheolog number(10),ID_Locatie number(10),ID_Detinator number(10));
Create Table Arheolog (ID number(10),Nume varchar2(255) NOT NULL ,ID_Locatie number(10),Specializare varchar2(255));
Create Table Detinator (ID number(10),Nume varchar2(255) NOT NULL ,Tip varchar2(255) NOT NULL);
Create Table Locatie (ID number(10),Nume_Sit varchar2(255) NOT NULL,Continent varchar2(255) NOT NULL,Tara varchar2(255) NOT NULL,Oras varchar2(255) NOT NULL);
Create Table Caracteristici (ID_Artefact number(10) UNIQUE NOT NULL,Culoare varchar2(255),Material varchar2(255),Perioada varchar2(255),Data_Descoperire date NOT NULL,Rol varchar2(255),Valoare_est varchar2(10));
Create Table Tipologie (ID number(10),Nume varchar2(255) NOT NULL,Origine varchar2(255), Perioada varchar2(255));
Create Table Incadrare (ID_Artefact number(10) NOT NULL, ID_Tipologie number(10) NOT NULL);
Create table Admin(Nume varchar2(256),Password varchar2(256),email varchar2(256));
Insert into Admin values('Leon','Daniel','leon.Daniel@gmail.com');

drop index detinator;
drop index locatie;
drop index muzeu_nume;
drop index cautare;
drop index index_arheolog;

create index detinator on artefact(id_detinator);
create index locatie on artefact(id_locatie);
create index muzeu_nume on detinator (tip,id,nume);
create index cautare on locatie(tara,oras,nume_sit);
create index index_arheolog on artefact (id_arheolog);

ALTER TABLE Artefact ADD CONSTRAINT 
     pk_Artefact PRIMARY KEY (ID);	 
ALTER TABLE Arheolog ADD CONSTRAINT 
     pk_Arheolog PRIMARY KEY (ID);
ALTER TABLE Detinator ADD CONSTRAINT 
     pk_Detinator PRIMARY KEY (ID);
ALTER TABLE Locatie ADD CONSTRAINT 
     pk_Locatie PRIMARY KEY (ID);
ALTER TABLE Tipologie ADD CONSTRAINT 
     pk_Tipologie PRIMARY KEY (ID);

ALTER TABLE Artefact ADD CONSTRAINT 
     fk_Artefact_Arheolog FOREIGN KEY (ID_Arheolog) 
           REFERENCES Arheolog(ID);  
ALTER TABLE Artefact ADD CONSTRAINT 
     fk_Artefact_Detinator FOREIGN KEY (ID_Detinator) 
           REFERENCES Detinator(ID);
ALTER TABLE Artefact ADD CONSTRAINT 
     fk_Artefact_Locatie FOREIGN KEY (ID_Locatie) 
           REFERENCES Locatie(ID);
ALTER TABLE Arheolog ADD CONSTRAINT 
     fk_Arheolog_Locatie FOREIGN KEY (ID_Locatie) 
           REFERENCES Locatie(ID);
ALTER TABLE Caracteristici ADD CONSTRAINT 
     fk_Caracteristici_Artefact FOREIGN KEY (ID_Artefact) 
           REFERENCES Artefact(ID);
ALTER TABLE Incadrare ADD CONSTRAINT 
     fk_Incadrare_Artefact FOREIGN KEY (ID_Artefact) 
           REFERENCES Artefact(ID);
ALTER TABLE Incadrare ADD CONSTRAINT 
     fk_Incadrare_Tipologie FOREIGN KEY (ID_Tipologie) 
           REFERENCES Tipologie(ID);
  
Alter table incadrare add constraint  unique_pereche unique(id_artefact,id_tipologie);
--Alter table locatie add constraint unique_location unique(nume_sit,continent,tara,oras);

set serveroutput on;
DECLARE

type ids IS TABLE OF VARCHAR2(255);
ids_match ids := ids();
continent number(10);
tara number(10);
oras number(10);
sit number(10);

valNume2 number(10);
valNume number(10);
nume varchar(255);
specializare varchar(255);
randoms number(10);

let varchar2(256);
isVowel number(10);
FUNCTION randomName(x IN number)  
RETURN varchar2
IS 
    randName varchar2(256); 
BEGIN 
  randName:='';
  let :='aeiou';
  isVowel := dbms_random.value(1,2);
   for i in 0..x  LOOP
    
    if isVowel = 1 then 
      randName:=randName || SUBSTR(let,dbms_random.value(1,5),1);
      isVowel:=2;
    else
      randName:=randName || CHR(97+dbms_random.value(0,25));
      isVowel:=1;
    END if;
   END LOOP;
  return randName;
END; 
BEGIN
ids_match.EXTEND(2000);

ids_match(1) := 'Africa';
ids_match(11) := 'Zambia';
ids_match(111) :='Livingstone';
ids_match(112) :='Kitwe';
ids_match(113) :='Rusaka';
ids_match(12) :='Somalia';
ids_match(121):='Mogadishu';
ids_match(122):='Merca';
ids_match(123):='Hargeisa';

ids_match(2) := 'Asia';
ids_match(21):='China';
ids_match(211):='Wuhan';
ids_match(212):='Shenyang';
ids_match(213):='Beijing';
ids_match(22):='Japonia';
ids_match(221):='Osaka';
ids_match(222):='Tokyo';
ids_match(223):='Kyoto';

ids_match(3) := 'America de Sud';
ids_match(31):='Brazilia';
ids_match(311):='Sao Paolo';
ids_match(312):='Rio de Janeiro';
ids_match(313):='Brasil';
ids_match(32):='Peru';
ids_match(321):='Cuzco';
ids_match(322):='Puno';
ids_match(323):='Trujilo';

ids_match(4) := 'America de Nord';
ids_match(41):='United states of America';
ids_match(411):='Iowa';
ids_match(412):='Texas';
ids_match(413):='Alabama';
ids_match(42):='Canada';
ids_match(421):='Toronto';
ids_match(422):='Quebec';
ids_match(423):='Montreal';

ids_match(5) := 'Europa';
ids_match(51):='Germania';
ids_match(511):='Berlin';
ids_match(512):='Munchen';
ids_match(513):='Dortmund';
ids_match(52):='Rusia';
ids_match(521):='Leningrad';
ids_match(522):='Moscova';
ids_match(523):='Priviet Sim';

ids_match(6) := 'Oceania';
ids_match(61):='Noua Zeelanda';
ids_match(611):='Christchurch';
ids_match(612):='Oakland';
ids_match(613):='Wellington';
ids_match(62):='Australia';
ids_match(621):='Sidney';
ids_match(622):='Perth';
ids_match(623):='P.Sherman 42 Wallaby Way Sidney';

ids_match(10):='Mormantul';
ids_match(20):='Piesa';
ids_match(30):='Templul';
ids_match(40):='Asezamantul';
ids_match(50):='Ruinele';
ids_match(60):='Ceteatea';
ids_match(70):='Biserica';
ids_match(80):='Castelul';

ids_match(1000):='Keops';
ids_match(1001):='Atenei';
ids_match(1002):='Poetului';
ids_match(1003):='Stefan Cel Mare';
ids_match(1004):='Apollo';
ids_match(1005):='Perfirii';
ids_match(1006):='Elena';
ids_match(1007):='Samuel';
ids_match(1008):='Ra';
ids_match(1009):='Afrodita';
ids_match(1010):='Samba';
ids_match(1011):='Evrika';
ids_match(1012):='Alexandru Macedon';
ids_match(1013):='Constantin Cel Mare';
ids_match(1014):='Decebal';



FOR i in 1..1000 LOOP
    
    continent := dbms_random.value(1,6);
    tara :=10* continent + dbms_random.value(1,2);
    oras :=10* tara +dbms_random.value(1,3);
    sit :=dbms_random.value(1,8);
    sit :=sit*10;
    Insert into Locatie Values(i,ids_match(sit)||' lui ' || ids_match(dbms_random.value(1000,1014)),ids_match(continent),ids_match(tara),ids_match(oras));

END LOOP;

ids_match(1):='Anca Ursachi';
ids_match(2):='Iosif Ostafe';
ids_match(3):='Larisa Rachieru';
ids_match(4):='Dragos Larion';
ids_match(5):='Teodora Andronic';
ids_match(6):='Vladut Minuti';
ids_match(7):='Daniel Oana';
ids_match(8):='Daria Ungureanu';
ids_match(9):='Rares Bradea';
ids_match(10):='Theodor Mitan';

ids_match(11):='Dinozauri';
ids_match(12):='Ninja';
ids_match(13):='Antichitati';
ids_match(14):='Hieroglife';
ids_match(15):='Mayasi';
ids_match(16):='Samurai';
ids_match(17):='Pokemoni';
ids_match(18):='Pterodactili';
ids_match(19):='Cuptoare cu microunde';
ids_match(20):='Troia';	
FOR i in 1..10000 LOOP
    
    valNume := dbms_random.value(1,10);
    valNume2 := dbms_random.value(1,10);
    randoms :=dbms_random.value(1,2);
    if randoms=1 then
      nume:=INITCAP(SUBSTR(ids_match(valNume),INSTR(ids_match(valNume),' ')+1)|| ' ' || INITCAP(SUBSTR(ids_match(valNume2),1,INSTR(ids_match(valNume2),' '))));  
    else
      nume:=INITCAP(SUBSTR(ids_match(valNume2),1,INSTR(ids_match(valNume2),' '))) || INITCAP(SUBSTR(ids_match(valNume),INSTR(ids_match(valNume),' ')+1));  
    end if;
    INSERT INTO Arheolog Values(i,nume,dbms_random.value(1,1000),ids_match(dbms_random.value(11,20)));

END LOOP;

ids_match(1):='Anca Ursachi';
ids_match(2):='Iosif Ostafe';
ids_match(3):='Larisa Rachieru';
ids_match(4):='Dragos Larion';
ids_match(5):='Teodora Andronic';
ids_match(6):='Vladut Minuti';
ids_match(7):='Daniel Oana';
ids_match(8):='Daria Ungureanu';
ids_match(9):='Rares Bradea';
ids_match(10):='Theodor Mitan';

ids_match(11):='Dinozauri';
ids_match(12):='Ninja';
ids_match(13):='Antichitati';
ids_match(14):='Hieroglife';
ids_match(15):='Mayasi';
ids_match(16):='Samurai';
ids_match(17):='Pokemoni';
ids_match(18):='Pterodactili';
ids_match(19):='Cuptoare cu microunde';
ids_match(20):='Troia';	

FOR i in 1..500 LOOP
    
    valNume := dbms_random.value(1,10);
    valNume2 := dbms_random.value(1,10);
    randoms :=dbms_random.value(1,2);
      nume:=INITCAP(SUBSTR(ids_match(valNume2),1,INSTR(ids_match(valNume2),' '))) || INITCAP(SUBSTR(ids_match(valNume),INSTR(ids_match(valNume),' ')+1));  
    INSERT INTO Detinator Values(i,'Muzeul de ' || ids_match(dbms_random.value(11,20)),'Muzeu');
END LOOP;

  ids_match.EXTEND(1000);
  


ids_match(1):='Sulita';
ids_match(2):='Platosa';
ids_match(3):='Iataganul';
ids_match(4):='Moneda';
ids_match(5):='Coiful';
ids_match(6):='Maceta';
ids_match(7):='Coasa';
ids_match(8):='Farfuria';
ids_match(9):='Ulciorul';
ids_match(10):='Cuptorul cu microunde a';
ids_match(11):='Tibia de pterodactil a';
ids_match(12):='Katana';

ids_match(13):='Iisus
';ids_match(14):='Napoleon
';ids_match(15):='Muhammad
';ids_match(16):='William Shakespeare
';ids_match(17):='Abraham Lincoln
';ids_match(18):='George Washington
';ids_match(19):='Adolf Hitler
';ids_match(20):='Aristotle
';ids_match(21):='Alexandru cel Mare
';ids_match(22):='Thomas Jefferson
';ids_match(23):='Henry VIII al Angliei
';ids_match(24):='Charles Darwin
';ids_match(25):='Elizabeth I a Angliei
';ids_match(26):='Karl Marx
';ids_match(27):='Julius Caesar
';ids_match(28):='Regina Victoria
';ids_match(29):='Martin Luther
';ids_match(30):='Joseph Stalin
';ids_match(31):='Albert Einstein
';ids_match(32):='Christopher Columbus
';ids_match(33):='Isaac Newton
';ids_match(34):='Charlemagne
';ids_match(35):='Theodore Roosevelt
';ids_match(36):='Wolfgang Amadeus Mozart
';ids_match(37):='Plato
';ids_match(38):='Louis XIV al Frantei
';ids_match(39):='Ludwig van Beethoven
';ids_match(40):='Ulysses S. Grant
';ids_match(41):='Leonardo da Vinci
';ids_match(42):='Augustus
';ids_match(43):='Carl Linnaeus
';ids_match(44):='Ronald Reagan
';ids_match(45):='Charles Dickens
';ids_match(46):='Paul the Apostle
';ids_match(47):='Benjamin Franklin
';ids_match(48):='George W. Bush
';ids_match(49):='Winston Churchill
';ids_match(50):='Genghis Khan
';ids_match(51):='Charles I of England
';ids_match(52):='Thomas Edison
';ids_match(53):='James I al Angliei
';ids_match(54):='Friedrich Nietzsche
';ids_match(55):='Franklin D. Roosevelt
';ids_match(56):='Sigmund Freud
';ids_match(57):='Alexander Hamilton
';ids_match(58):='Mohandas Karamchand Gandhi
';ids_match(59):='Woodrow Wilson
';ids_match(60):='Johann Sebastian Bach
';ids_match(61):='Galileo Galilei
';ids_match(62):='Oliver Cromwell
';ids_match(63):='James Madison
';ids_match(64):='Gautama Buddha
';ids_match(65):='Mark Twain
';ids_match(66):='Edgar Allan Poe
';ids_match(67):='Joseph Smith, Jr.
';ids_match(68):='Adam Smith
';ids_match(69):='David, Regele Israelului
';ids_match(70):='George III of the United Kingdom
';ids_match(71):='Immanuel Kant
';ids_match(72):='James Cook
';ids_match(73):='John Adams
';ids_match(74):='Richard Wagner
';ids_match(75):='Pyotr Ilyich Tchaikovsky
';ids_match(76):='Voltaire
';ids_match(77):='Sf?ntul Petre
';ids_match(78):='Andrew Jackson
';ids_match(79):='Constantine the Great
';ids_match(80):='Socrates
';ids_match(81):='Elvis Presley
';ids_match(82):='William Cuceritorul
';ids_match(83):='John F. Kennedy
';ids_match(84):='Augustine of Hippo
';ids_match(85):='Vincent van Gogh
';ids_match(86):='Nicolaus Copernicus
';ids_match(87):='Vladimir Lenin
';ids_match(88):='Robert E. Lee
';ids_match(89):='Oscar Wilde
';ids_match(90):='Charles II al Angliei
';ids_match(91):='Cicero
';ids_match(92):='Jean-Jacques Rousseau
';ids_match(93):='Francis Bacon
';ids_match(94):='Richard Nixon
';ids_match(95):='Louis XVI of France
';ids_match(96):='Charles V, Holy Roman Emperor
';ids_match(97):='King Arthur
';ids_match(98):='Michelangelo
';ids_match(99):='Philip II of Spain
';ids_match(100):='Johann Wolfgang von Goethe
';ids_match(101):='Ali, founder of Sufism
';ids_match(102):='Thomas Aquinas
';ids_match(103):='Pope John Paul II
';ids_match(104):='Rene Descartes
';ids_match(105):='Nikola Tesla
';ids_match(106):='Harry S. Truman
';ids_match(107):='Joan of Arc
';ids_match(108):='Dante Alighieri
';ids_match(109):='Otto von Bismarck
';ids_match(110):='Grover Cleveland
';ids_match(111):='John Calvin
';ids_match(112):='John Locke';

FOR i in 1..20000 LOOP
    
   
    INSERT INTO Artefact Values(i,
    ids_match(dbms_random.value(1,12)) || ' lui ' || ids_match(dbms_random.value(13,112)),
    
    dbms_random.value(1,10000),
    dbms_random.value(1,1000),
    dbms_random.value(1,500));
  
END LOOP;


ids_match(1):='Verde';
ids_match(2):='Rosu';
ids_match(3):='Albastru';
ids_match(4):='Galben';
ids_match(5):='Negru';

ids_match(6):='Panza';
ids_match(7):='Cupru';
ids_match(8):='Aur';
ids_match(9):='Lemn';
ids_match(10):='Marmura';

ids_match(11):='Renascentista';
ids_match(12):='Elena';
ids_match(13):='Pre Troiana';
ids_match(14):='Inainte de Hristos';
ids_match(15):='Secolul XII';

ids_match(16):='Protectie';
ids_match(17):='Arma';
ids_match(18):='Uz Casnic';
ids_match(19):='Pentru Razboi';
ids_match(20):='Stiintific';


FOR i in 1..20000 LOOP
    
    randoms:=dbms_random.value(1,3);


    if randoms=1 then nume:='K';
    elsif randoms=2 then nume:='M';
    elsif randoms=3 then nume:='B'; END IF;  
      
    specializare:=to_char((dbms_random.value(1,100)),'99') || nume;
    
    
   INSERT INTO Caracteristici Values(i,
   ids_match(dbms_random.value(1,5)),
   ids_match(dbms_random.value(6,10)),
   ids_match(dbms_random.value(11,15)),
   SYSDATE - (dbms_random.value(10,365000)),
   ids_match(dbms_random.value(16,20)),
   specializare);
  
END LOOP;

ids_match(1):='Ninja';
ids_match(2):='Samurai';
ids_match(3):='Mayasa';
ids_match(4):='Romana';
ids_match(5):='Greaca';


ids_match(11):='De Piatra';
ids_match(12):='Crestina';
ids_match(13):='Intunecata';
ids_match(14):='Ciuma Neagra';
ids_match(15):='Sec X-XV';

ids_match(6):='Preistorica';
ids_match(7):='Evul Mediu';
ids_match(8):='Antica';
ids_match(9):='Epoca Clasica';
ids_match(10):='Epoca Renascentista';

FOR i in 1..5 LOOP
    
    Insert into tipologie values(i,ids_match(i),ids_match(i+5),ids_match(i+10));
  
END LOOP;


  for i in 1..20000 LOOP
  
    randoms:=dbms_random.value(1,3);
    if randoms=2 then
      INSERT INTO Incadrare values(i,dbms_random.value(1,5));
    elsif randoms=3 then
      INSERT INTO Incadrare values(i,dbms_random.value(1,3));
      INSERT INTO Incadrare values(i,dbms_random.value(4,5));
    END IF;
  
  END LOOP;

END;
/
CREATE OR REPLACE Package AdministratorLogin
as
FUNCTION Login(username admin.nume%type,inputPassword admin.password%type)
return number;
END AdministratorLogin;
/
CREATE OR REPLACE Package Body AdministratorLogin as
FUNCTION Login(username admin.nume%type,inputPassword admin.password%type)
return number
IS
entries integer:=0;
BEGIN
  select count(*) into entries from admin where nume like username and password like inputPassword;
  entries:=1;
  if entries != 1 then
    return 0;
  end if;
  return 1;
END;
end AdministratorLogin;
/

CREATE OR REPLACE FUNCTION GET_COLUMNS_NAME(p_selectQuery IN VARCHAR2) RETURN cols_name PIPELINED IS
    v_cursor_id integer;
    v_col_cnt integer;
    v_columns dbms_sql.desc_tab;
begin
    v_cursor_id := dbms_sql.open_cursor;
    dbms_sql.parse(v_cursor_id, p_selectQuery, dbms_sql.native);
    dbms_sql.describe_columns(v_cursor_id, v_col_cnt, v_columns);

    for i in 1 .. v_columns.count loop
        pipe row(v_columns(i).col_name);
    end loop;

    dbms_sql.close_cursor(v_cursor_id);
    return;
exception when others then
    dbms_sql.close_cursor(v_cursor_id);
    raise;
end;
/
CREATE OR REPLACE PROCEDURE getArtefactsPer(output out sys_refcursor) AS
loc varchar2(256);
BEGIN

loc :='oras';
if (loc like 'oras') then
open output for
select l.ORAS,t.nume,count(*) from locatie l
join artefact a on l.id =a.id_locatie
join incadrare i on i.id_artefact=a.id
join tipologie t on t.id=i.id_tipologie
group by l.oras ,t.nume order by l.oras,count(*); 
end if;

if (loc like 'tara') then
open output for
select l.tara,t.nume,count(*) from locatie l
join artefact a on l.id =a.id_locatie
join incadrare i on i.id_artefact=a.id
join tipologie t on t.id=i.id_tipologie
group by l.tara ,t.nume order by l.tara,count(*);
end if;

if (loc like 'continent') then
open output for
select l.continent,t.nume,count(*) from locatie l
join artefact a on l.id =a.id_locatie
join incadrare i on i.id_artefact=a.id
join tipologie t on t.id=i.id_tipologie
group by l.continent ,t.nume order by l.continent,count(*);
end if;

EXCEPTION
WHEN no_data_found THEN
  open output for select 'no data found' from  dual;
when OTHERS then
  open output for select 'unhadeled exception' from  dual;
END getArtefactsPer;
/
create or replace package distributie_arheologi is 
  function grad_arheolog(p_id in arheolog.id%type) return varchar2;
  function numar(p_string varchar2) return pls_integer;
  procedure distribuire (p_curs out sys_refcursor);
end distributie_arheologi;
/
create or replace package body distributie_arheologi is
 function nr_descoperiri(p_id in arheolog.id%type) return pls_integer is
  v_int pls_integer;
  begin 
    select count(*) into v_int from arheolog a join artefact l on a.id=l.id_arheolog where a.id=p_id;
    return v_int;
  end nr_descoperiri;

 function grad_arheolog(p_id in arheolog.id%type) return varchar2 is
  v_string varchar2(255);
  v_int pls_integer;
  begin
    v_int:=nr_descoperiri(p_id);
    if v_int=0 then v_string:='Begginers';
    elsif v_int =1 or v_int=2 then v_string:='Novices';
    elsif v_int=3 or v_int=4 then v_string:='Professionals';
    else v_string:='Experts';
    end if;
    return v_string;
  end grad_arheolog;

 function numar (p_string varchar2) return pls_integer is
    v_int pls_integer;
  begin
    select count(*) into v_int from arheolog where grad_arheolog(id)=p_string;
    return v_int;
  end numar;

 procedure distribuire(p_curs out sys_refcursor) is
    v_total pls_integer;
    empty_table EXCEPTION;
    pragma exception_init(empty_table,-20001);
  begin
    select count(*) into v_total from arheolog;
    if v_total=0 then
      raise empty_table;
    else
    open p_curs for 
      select grad_arheolog(id),numar(grad_arheolog(id)),trunc((numar(grad_arheolog(id))*100)/v_total,2)||'%' from arheolog group by grad_arheolog(id);
    end if;
  exception
    when empty_table then
      open p_curs for
        select 'Va rugam contactati un admin,una dintre tabele a fost golita!' from dual;
  end distribuire;
end distributie_arheologi;
/
create or replace package best_furnizor is
  function max_muzeu(p_id in detinator.id%type) return pls_integer;
  procedure tara_per_muzeu(p_cursor out sys_refcursor);
end best_furnizor;
/
create or replace package body best_furnizor is
  function max_muzeu(p_id in detinator.id%type)return pls_integer is
  v_total pls_integer;
  begin
    select max(total) into v_total from
     (select count(a.id) total from detinator m
      join artefact a on a.ID_DETINATOR=m.ID 
      join LOCATIE l on l.ID=a.ID_LOCATIE
      where m.tip='Muzeu' and m.id=p_id
      group by m.id,l.tara,l.oras);
      return v_total;
  end;
  procedure tara_per_muzeu(p_cursor out sys_refcursor) is
    v_total_muz pls_integer;
    v_total pls_integer;
    no_muzeu EXCEPTION;
    pragma exception_init(no_muzeu,-20003);
    empty_table EXCEPTION;
    pragma exception_init(empty_table,-20002);
  begin
    select count(*) into v_total_muz from detinator where tip='Muzeu';
    select count(*) into v_total from detinator;
    if v_total=0 then raise empty_table;
    elsif v_total_muz=0 then raise no_muzeu;
    else
    open p_cursor for 
      select m.nume,l.tara,l.oras from detinator m
        join artefact a on a.ID_DETINATOR=m.ID 
        join LOCATIE l on l.ID=a.ID_LOCATIE
        where m.tip='Muzeu' 
        group by m.id,m.nume,l.tara,l.oras
        having count(a.id)=max_muzeu(m.id);
      end if;
  exception
    when empty_table then
     open p_cursor for select 'Baza de date a fost compromisa,va rugam contactati un administrator' from dual;
    when no_muzeu then
      open p_cursor for select 'Nu exista informatii legate de vreun muzeu in momentul actual!' from dual;
  end;
end best_furnizor;
/
create or replace package origine_tipologie is
  function max_tipologie(p_id in tipologie.id%type) return pls_integer;
  procedure tara_per_tipologie(p_cursor out sys_refcursor);
end origine_tipologie;
/
create or replace package body origine_tipologie is
  function max_tipologie(p_id in tipologie.id%type) return pls_integer is
  v_total pls_integer;
  begin
    select max(total) into v_total from
     (select count(a.id) total from tipologie t
      join incadrare i on i.id_tipologie=t.ID 
      join artefact a on a.id=i.id_artefact
      join LOCATIE l on l.ID=a.ID_LOCATIE
      where t.id=p_id
      group by t.id,l.tara);
      return v_total;
  end;
  procedure tara_per_tipologie(p_cursor out sys_refcursor) is
    v_total pls_integer;
    empty_table2 EXCEPTION;
    pragma exception_init(empty_table2,-20004);
  begin
    select count(*) into v_total from tipologie;
    if v_total=0 then raise empty_table2;
    else
    open p_cursor for 
      select t.nume,l.tara,count(a.id) from tipologie t
      join incadrare i on i.id_tipologie=t.ID 
      join artefact a on a.id=i.id_artefact
      join LOCATIE l on l.ID=a.ID_LOCATIE
      group by t.id,t.nume,l.tara
        having count(a.id)=max_tipologie(t.id);
      end if;
  exception
    when empty_table2 then
     open p_cursor for select 'Baza de date a fost compromisa,va rugam contactati un administrator' from dual;
  end;
end origine_tipologie;
/
CREATE OR REPLACE PROCEDURE locatie1 (emp_cursor OUT SYS_REFCURSOR)
AS
v_id_locatie integer;
v_nr_locatii integer;
locatie_inexistenta EXCEPTION;
  PRAGMA EXCEPTION_INIT(locatie_inexistenta, -20001);
CURSOR locatii( idDetinator integer) IS (select id_locatie,  COUNT(id_locatie) from Artefact where idDetinator = id_detinator GROUP BY id_locatie);

BEGIN
v_nr_locatii := 0;
FOR i in (select id, nume, tip from DETINATOR)
LOOP
  OPEN locatii(i.id);
  LOOP
    FETCH locatii into v_id_locatie, v_nr_locatii;
    EXIT WHEN locatii%NOTFOUND;
  END LOOP;
    IF (v_nr_locatii = 0) THEN RAISE locatie_inexistenta;
    END IF;
  CLOSE locatii;
END LOOP;
OPEN emp_cursor FOR
SELECT d.nume || ' are locatie favorita: ' || l.oras || ' - ' || l.nume_sit  FROM detinator d JOIN artefact a ON d.id = a.id_detinator
          JOIN locatie l ON l.id = a.id_locatie GROUP BY l.id,l.nume_sit, l.oras, d.nume
         HAVING COUNT(l.id) = (SELECT MAX(COUNT(id_locatie)) FROM artefact WHERE id_locatie = l.id GROUP BY id_locatie);

EXCEPTION
    WHEN locatie_inexistenta THEN
     OPEN emp_cursor FOR SELECT 'S-a gasit un artefact fara locatie' FROM dual;
    WHEN NO_DATA_FOUND THEN
      open emp_cursor for select 'No data found in DB' from dual;

END locatie1;
/
CREATE OR REPLACE FUNCTION tip_artefact( idArtefact integer)
return varchar
AS
tip varchar(20);

BEGIN

SELECT CASE
WHEN EXISTS (SELECT a.id
                  FROM tipologie t JOIN incadrare inc ON inc.id_tipologie = t.id
                  JOIN artefact a ON a.id = inc.id_artefact
                  WHERE idArtefact = id_artefact
                  GROUP BY a.id
                  HAVING count(inc.id_artefact) > 1
                  )
THEN 'Generic'

WHEN EXISTS (SELECT a.id
                  FROM tipologie t JOIN incadrare inc ON inc.id_tipologie = t.id
                  JOIN artefact a ON a.id = inc.id_artefact
                  WHERE idArtefact = id_artefact
                  GROUP BY a.id
                  HAVING count(inc.id_artefact) = 1
                  )
THEN 'Regular'

ELSE
    'Unic'
END 
INTO tip
FROM DUAL;

return tip;
END tip_artefact;
/

CREATE OR REPLACE PROCEDURE distr_artefacte (emp_cursor OUT SYS_REFCURSOR)
AS
v_nr_artefacte integer;
v_nr_tipologii integer;
v_id_artefact integer;
v_generic integer;
v_nume_artefact artefact.nume%type;
CURSOR tipologii( idTipologie integer) IS (select id_artefact from Incadrare 
                                              where idTipologie = id_tipologie);

BEGIN

OPEN emp_cursor FOR
SELECT 'Fara tipologie ' || a.nume || ' tip artefact: Unic'
             FROM  artefact a WHERE tip_artefact(a.id) = 'Unic'
UNION
SELECT t.nume || ' - artefact: ' || a.nume || ' tip artefact: ' || tip_artefact(a.id)
            FROM tipologie t JOIN incadrare inc ON inc.id_tipologie = t.id
            JOIN artefact a ON a.id = inc.id_artefact
            GROUP BY a.nume, a.id, t.nume, t.id;
EXCEPTION
  when NO_DATA_FOUND then
    OPEN emp_cursor FOR
      select 'no data found ' from dual;
END distr_artefacte;
/
CREATE OR REPLACE Package artefact_administration
as

PROCEDURE addArtefact(nume artefact.nume%type
,descoperitor arheolog.nume%type
,loc locatie.nume_sit%type
,culoare caracteristici.culoare%type 
,material caracteristici.material%type
,perioada caracteristici.perioada%type
,data_desc caracteristici.data_descoperire%type
,rol caracteristici.rol%type
,valoare caracteristici.valoare_est%type
,detinut detinator.nume%type
,tipo tipologie.nume%type);

PROCEDURE deleteArtefact(numeInput artefact.nume%type);

PROCEDURE updateArtefact(numeInput artefact.nume%type
,descoperitor arheolog.nume%type
,loc locatie.nume_sit%type
,culoareInput caracteristici.culoare%type 
,materialInput caracteristici.material%type
,perioadaInput caracteristici.perioada%type
,data_desc caracteristici.data_descoperire%type
,rolInput caracteristici.rol%type
,valoare caracteristici.valoare_est%type
,detinut detinator.nume%type
,tipo tipologie.nume%type);
end artefact_administration;
/
CREATE OR REPLACE Package Body artefact_administration as
PROCEDURE addArtefact(nume artefact.nume%type
,descoperitor arheolog.nume%type
,loc locatie.nume_sit%type
,culoare caracteristici.culoare%type 
,material caracteristici.material%type
,perioada caracteristici.perioada%type
,data_desc caracteristici.data_descoperire%type
,rol caracteristici.rol%type
,valoare caracteristici.valoare_est%type
,detinut detinator.nume%type
,tipo tipologie.nume%type)
IS
v_id integer;
v_id_arh integer;
v_id_loc integer;
v_id_detinut integer;
v_id_tip integer;
BEGIN
  select id into v_id_arh from arheolog where nume like descoperitor and rownum<=1;
  select count(*) into v_id from artefact;
  select id into v_id_loc from locatie where nume_sit like loc  and rownum<=1;
  v_id:=v_id+1;
  select id into v_id_detinut from detinator where nume like detinut and rownum<=1;
  select id into v_id_tip from tipologie where nume like tipo;
  insert into artefact values(v_id,nume,v_id_arh,v_id_loc,v_id_detinut);
  insert into caracteristici values(v_id,culoare,material,perioada,data_desc,rol ,valoare);
  insert into incadrare values(v_id,v_id_tip);
     exception
     when NO_DATA_FOUND then
       raise_application_error (-20001,'Unul din campurile introduse (locatie,detinator,arheolog,tipologie) nu se afla in baza de date');
    when OTHERS then
        raise_application_error (-20002,'Campurile introduse sunt corecte,alta eroare neasteptata a aparut');
END;

PROCEDURE deleteArtefact(numeInput artefact.nume%type) is 
v_id integer;
BEGIN
select id into v_id from artefact where nume like numeInput and rownum<=1;
delete from caracteristici where id_artefact = v_id;
delete from incadrare where id_artefact = v_id;
delete from artefact where id = v_id;
     exception
     when NO_DATA_FOUND then
       raise_application_error (-20003,'Artefactul nu a fost gasit in baza de date');
END;

PROCEDURE updateArtefact(numeInput artefact.nume%type
,descoperitor arheolog.nume%type
,loc locatie.nume_sit%type
,culoareInput caracteristici.culoare%type 
,materialInput caracteristici.material%type
,perioadaInput caracteristici.perioada%type
,data_desc caracteristici.data_descoperire%type
,rolInput caracteristici.rol%type
,valoare caracteristici.valoare_est%type
,detinut detinator.nume%type
,tipo tipologie.nume%type)
is
v_id integer;
BEGIN
if(descoperitor is not null) then
select id into v_id from arheolog where nume like descoperitor and rownum<=1;
UPDATE artefact
SET id_arheolog=v_id
WHERE nume like numeInput; 
end if;

if(loc is not null) then
select id into v_id from locatie where nume_sit like loc and rownum<=1;
UPDATE artefact
SET id_locatie=v_id
WHERE nume like numeInput; 
end if;

if(culoareInput is not null) then

UPDATE caracteristici
SET culoare=culoareInput
WHERE id_artefact = (select id from artefact where nume like numeInput and rownum <=1) ;
end if;

if(materialInput is not null) then

UPDATE caracteristici
SET material=materialInput
WHERE id_artefact = (select id from artefact where nume like numeInput and rownum <=1) ;
end if;

if(perioadaInput is not null) then

UPDATE caracteristici
SET perioada=perioadaInput
WHERE id_artefact = (select id from artefact where nume like numeInput and rownum <=1) ;
end if;

--questionable
if(data_desc is not null) then

UPDATE caracteristici
SET data_descoperire=data_desc
WHERE id_artefact = (select id from artefact where nume like numeInput and rownum <=1) ;
end if;

if(rolInput is not null) then

UPDATE caracteristici
SET rol=rolInput
WHERE id_artefact = (select id from artefact where nume like numeInput and rownum <=1) ;
end if;

if(valoare is not null) then

UPDATE caracteristici
SET valoare_est=valoare
WHERE id_artefact = (select id from artefact where nume like numeInput and rownum <=1) ;
end if;

if(loc is not null) then
select id into v_id from detinator where nume like detinut and rownum<=1;
UPDATE artefact
SET id_detinator=v_id
WHERE nume like numeInput;
end if;

if(loc is not null) then
select id into v_id from detinator where nume like detinut and rownum<=1;
UPDATE artefact
SET id_detinator=v_id
WHERE nume like numeInput;
end if;

if(loc is not null) then
select id into v_id from tipologie where nume like tipo and rownum<=1;
UPDATE incadrare
SET id_tipologie=v_id
WHERE id_artefact = (select id from artefact where nume like numeInput and rownum <=1) ;
end if;
     exception
     when NO_DATA_FOUND then
       raise_application_error (-20004,'Artefactul,arheologul,locatia,detinatorul sau tipologia nu au fost gasite in baza de date.');
END;
end artefact_administration;
/
CREATE OR REPLACE Package Administrator
as
FUNCTION Login(username admin.nume%type,inputPassword admin.password%type)
return number;
PROCEDURE register_user(username admin.nume%type,inputPassword admin.password%type,email admin.email%type);
PROCEDURE remove_user(username admin.nume%type,inputPassword admin.password%type); 
END Administrator;
/
CREATE OR REPLACE Package Body Administrator as
FUNCTION Login(username admin.nume%type,inputPassword admin.password%type)
return number
IS
entries integer;
BEGIN
  Select count(*) into entries from Admin where nume like username and password like inputPassword;
  if entries != 1 then
    return 0;
  end if;
  return 1;
END;

PROCEDURE register_user(username admin.nume%type,inputPassword admin.password%type,email admin.email%type)
IS
BEGIN
  Insert into Admin values (username,inputPassword,email);
END;

PROCEDURE remove_user(username admin.nume%type,inputPassword admin.password%type)
is
BEGIN
delete from admin where nume like username and password like inputPassword;
     exception
     when NO_DATA_FOUND then
       raise_application_error (-20004,'Contul nu u fost gasit in baza de date.');
END;
end Administrator;
/*
Select administrator.login('Leon','Daniel') from dual;
Select * from Admin where nume like 'Leon' and password like 'Daniel';
Select * from Artefact;
Select * from Arheolog;
Select * from Locatie;
Select * from Tipologie;
Select * from Incadrare;
Select * from Detinator;
Select * from Caracteristici where valoare_est like '%#%';
*/  
