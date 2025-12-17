use grupp2;

/* --- TABLE --- */

drop table if exists user_session;

create table user_session (
    id varchar(100),
    uid char(12) not null,
    started datetime default now(),
    last_activity datetime default now(),
    
    primary key(id)
) engine=innodb;



drop table if exists session_history;

create table session_history (
    id int auto_increment,
    session_id varchar(100),
    uid char(12) not null,
    started datetime not null,
    last_activity datetime not null,
    ended datetime default now(),
    
    primary key(id)
) engine=innodb;



/* --- PROCEDURES --- */

drop procedure if exists register_session;

create procedure register_session (in in_session_id varchar(100), in in_uid char(12))
begin
    insert into user_session(id, uid) values 
    (
        in_session_id,
        in_uid
    );
end;



drop procedure if exists get_uid;

create procedure get_uid(in in_session_id varchar(100))
begin
    select uid
    from user_session
    where id = in_session_id;
    
    update user_session
    set last_activity = now()
    where id = in_session_id;
end;



drop procedure if exists get_timediff;

create procedure get_timediff(in in_session_id varchar(100))
begin
    select timestampdiff(second, started, last_activity) as time_diff
    from user_session 
    where in_session_id = user_session.id;
end;



drop procedure if exists end_session;

create procedure end_session(in in_session_id varchar(100))
begin
    insert into session_history(session_id, uid, started, last_activity)
    select 
        user_session.id,
        user_session.uid,
        user_session.started,
        user_session.last_activity
    from user_session
    where in_session_id = user_session.id;
    
    delete from user_session where id = in_session_id; 
end;

-- call get_uid('fy742b47fcb9fe');