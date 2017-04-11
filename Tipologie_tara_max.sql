create or replace package origine_tipologie is
  function max_tipologie(p_id in tipologie.id%type) return pls_integer;
  procedure tara_per_tipologie(p_cursor out sys_refcursor);
end origine_tipologie;
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










/*
drop package origine_tipologie;


set serveroutput on;
declare 
  l_cursor sys_refcursor;
  l_nume DETINATOR.NUME%type;
  l_tare LOCATIE.TARA%type;
  l_total pls_integer;
begin
  ORIGINE_TIPOLOGIE.TARA_PER_TIPOLOGIE(p_cursor=>l_cursor);
  loop
    fetch l_cursor
    into l_nume,l_tare,l_total;--l_nume_sit;
    exit when l_cursor%notfound;
    dbms_output.put_line(l_nume||' '||l_tare||'->'||l_total);
  end loop;
  close l_cursor;
end;
*/