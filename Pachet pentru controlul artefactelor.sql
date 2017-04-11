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
END;

PROCEDURE deleteArtefact(numeInput artefact.nume%type) is 
v_id integer;
BEGIN
select id into v_id from artefact where nume like numeInput and rownum<=1;
delete from caracteristici where id_artefact = v_id;
delete from incadrare where id_artefact = v_id;
delete from artefact where id = v_id;
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
END;
end artefact_administration;


begin
  artefact_administration.addArtefact('Battle axe of Olaf the migthy','Dragos Bradea','Templul lui Samba','gri','fier','Viking Age',sysdate,'Arma','50k', 'Muzeul de Antichitati','Romana');
  --artefact_administration.deleteArtefact('Battle axe of Olaf the migthy');
  --artefact_administration.updateArtefact('Battle axe of Olaf the migthy',NULL,NULL,NULL,NULL,NULL,sysdate-15,NULL,NULL,NULL,NULL);
end;

--select * from artefact a join caracteristici c on c.id_artefact=a.id where a.id>20000;