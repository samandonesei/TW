create index detinator on artefact(id_detinator);
create index locatie on artefact(id_locatie);
create index muzeu_nume on detinator (tip,id,nume);
create index cautare on locatie(tara,oras,nume_sit);

create or replace package best_furnizor is
  function max_muzeu(p_id in detinator.id%type) return pls_integer;
  procedure tara_per_muzeu(p_cursor out sys_refcursor);
end best_furnizor;
create or replace package body best_furnizor is
  function max_muzeu(p_id in detinator.id%type)return pls_integer is
  v_total pls_integer;
  begin
    select max(total) into v_total from
     (select count(a.id) total from detinator m
      join artefact a on a.ID_DETINATOR=m.ID 
      join LOCATIE l on l.ID=a.ID_LOCATIE
      where m.tip='Muzeu' and m.id=p_id
      group by m.id,l.tara,l_oras);
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
      select m.nume,l.tara,l_oras from detinator m
        join artefact a on a.ID_DETINATOR=m.ID 
        join LOCATIE l on l.ID=a.ID_LOCATIE
        where m.tip='Muzeu' 
        group by m.id,m.nume,l.tara,l_oras
        having count(a.id)=max_muzeu(m.id);
      end if;
  exception
    when empty_table then
     open p_cursor for select 'Baza de date a fost compromisa,va rugam contactati un administrator' from dual;
    when no_muzeu then
      open p_cursor for select 'Nu exista informatii legate de vreun muzeu in momentul actual!' from dual;
  end;
end best_furnizor;


/*
drop package best_furnizor;

declare 
  l_cursor sys_refcursor;
  l_nume DETINATOR.NUME%type;
  --l_int pls_integer;
  l_tare LOCATIE.TARA%type;
  l_oras LOCATIE.ORAS%type;
begin
  best_furnizor.tara_per_muzeu(p_cursor=>l_cursor);
  loop
    fetch l_cursor
    into l_nume,l_tare,l_oras;
    exit when l_cursor%notfound;
    dbms_output.put_line(l_nume||' '||l_tare||' '||l_oras);
  end loop;
  close l_cursor;
end;*/
