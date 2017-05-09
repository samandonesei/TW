CREATE OR REPLACE PROCEDURE getArtefactsPer(loc in varchar2,output out sys_refcursor) AS
BEGIN

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
