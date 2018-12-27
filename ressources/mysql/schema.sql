create table migration_versions
(
  version varchar(255) not null
    primary key
)
  collate = utf8_unicode_ci;

create table trick_group
(
  id   int auto_increment
    primary key,
  slug varchar(200) not null,
  name varchar(200) not null
)
  collate = utf8mb4_unicode_ci;

create table user
(
  id            int auto_increment
    primary key,
  first_name    varchar(100) not null,
  last_name     varchar(100) not null,
  password      longtext     not null,
  user_name     varchar(200) not null,
  email         varchar(200) not null,
  state         int          not null,
  token         varchar(40)  not null,
  date_create   datetime     not null,
  date_validate datetime     null,
  avatar        varchar(255) not null,
  constraint UNIQ_8D93D64924A232CF
  unique (user_name),
  constraint UNIQ_8D93D649E7927C74
  unique (email)
)
  collate = utf8mb4_unicode_ci;

create table password_recovery
(
  id                int auto_increment
    primary key,
  user_related_id   int          null,
  token             varchar(48)  not null,
  date_create       datetime     not null,
  end_date_validity datetime     not null,
  date_used         datetime     null,
  ip                varchar(100) not null,
  constraint FK_63D40109E60506ED
  foreign key (user_related_id) references user (id)
)
  collate = utf8mb4_unicode_ci;

create index IDX_63D40109E60506ED
  on password_recovery (user_related_id);

create table trick
(
  id             int auto_increment
    primary key,
  trick_group_id int          not null,
  user_id        int          not null,
  slug           varchar(200) not null,
  name           varchar(200) not null,
  description    longtext     not null,
  date_create    datetime     not null,
  date_update    datetime     null,
  constraint FK_D8F0A91E9B875DF8
  foreign key (trick_group_id) references trick_group (id),
  constraint FK_D8F0A91EA76ED395
  foreign key (user_id) references user (id)
)
  collate = utf8mb4_unicode_ci;

create table comments
(
  id          int auto_increment
    primary key,
  trick_id    int      not null,
  user_id     int      not null,
  date_create datetime not null,
  content     longtext not null,
  constraint FK_5F9E962AA76ED395
  foreign key (user_id) references user (id),
  constraint FK_5F9E962AB281BE2E
  foreign key (trick_id) references trick (id)
)
  collate = utf8mb4_unicode_ci;

create index IDX_5F9E962AA76ED395
  on comments (user_id);

create index IDX_5F9E962AB281BE2E
  on comments (trick_id);

create table movies
(
  id          int auto_increment
    primary key,
  user_id     int                                not null,
  trick_id    int                                not null,
  date_create datetime default CURRENT_TIMESTAMP not null,
  url_movie   varchar(255)                       not null,
  constraint FK_C61EED30A76ED395
  foreign key (user_id) references user (id),
  constraint FK_C61EED30B281BE2E
  foreign key (trick_id) references trick (id)
)
  collate = utf8mb4_unicode_ci;

create index IDX_C61EED30A76ED395
  on movies (user_id);

create index IDX_C61EED30B281BE2E
  on movies (trick_id);

create table pictures
(
  id                    int auto_increment
    primary key,
  user_id               int                                not null,
  trick_id              int                                null,
  picture_relative_path varchar(255)                       not null,
  date_create           datetime default CURRENT_TIMESTAMP not null,
  constraint FK_8F7C2FC0A76ED395
  foreign key (user_id) references user (id),
  constraint FK_8F7C2FC0B281BE2E
  foreign key (trick_id) references trick (id)
)
  collate = utf8mb4_unicode_ci;

create index IDX_8F7C2FC0A76ED395
  on pictures (user_id);

create index IDX_8F7C2FC0B281BE2E
  on pictures (trick_id);

create index IDX_D8F0A91E9B875DF8
  on trick (trick_group_id);

create index IDX_D8F0A91EA76ED395
  on trick (user_id);

