use grupp2;

drop table if exists user_session;
drop table if exists session_history;

create table user_session (
    id varchar(100),
    uid char(12) not null,
    started datetime default now(),
    last_activity datetime default now(),
    
    primary key(id)
) engine=innodb;

create table session_history (
    id varchar(100),
    uid char(12) not null,
    started datetime not null,
    last_activity datetime not null,
    ended datetime default now();
    
    primary key(id)
) engine=innodb;


drop procedure if exists register_session;
drop procedure if exists get_uid;
drop procedure if exists end_session;

create procedure register_session (in in_session_id varchar(100), in in_uid char(12))
begin
    insert into user_session(id, uid) values 
    (
        in_session_id,
        in_uid
    );
end;

/*create procedure register_session (in in_session_id varchar(100), in in_uid char(12))
begin
    if not exists (select uid from user_session where id = in_session_id) then
        insert into user_session(id, uid) values 
        (
            in_session_id,
            in_uid
        );
    end if;
end;*/

create procedure get_uid(in in_session_id varchar(100))
begin
    /* set @diff_min = select timestampdiff(minute, started, last_activity) from user_session where in_session_id = user_session.id;
    set @time_lim = 60 -- minutes
    
    insert into session_history(id, uid, started, last_activity, ended) values (
        user_session.id,
        user_session.uid,
        user_session.started,
        user_session.last_activity,
        now()
    )
    where timestampdiff(minute, started, last_activity) > @time_lim;
    delete from user_session where 
    
    else*/
        select uid
        from user_session
        where id = in_session_id;
        
        update user_session
        set last_activity = now()
        where id = in_session_id;
    -- end if;
end;

create procedure end_session(in in_session_id varchar(100))
begin
    delete from user_session where id = in_session_id; 
end;

call register_session('fy742b47fcb9fe', '194806190000');
-- call get_uid('fy742b47fcb9fe');