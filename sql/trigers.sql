create or replace TRIGGER ins_arch_id_trg
            before insert on arheolog
            for each row
                begin
            if :new.id is null then
                select count(*)+1 into :new.id from arheolog;
            end if;
            end;
create or replace TRIGGER ins_artefact_id_trg
            before insert on artefact
            for each row
                begin
            if :new.id is null then
                select count(*)+1 into :new.id from artefact;
            end if;
            end;
create or replace TRIGGER ins_loc_id_trg
            before insert on locatie
            for each row
                begin
            if :new.id is null then
                select count(*)+1 into :new.id from locatie;
            end if;
            end;