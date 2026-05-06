create table users(
    id int auto_increment primary key,
    name varchar(255) not null,
    email varchar(255) not null unique,
    password varchar(255) not null,
    role varchar(255) not null default 'user',
    last_seen timestamp default current_timestamp,
    created_at timestamp default current_timestamp,
    updated_at timestamp default current_timestamp on update current_timestamp
);

create table accounts (
    id int auto_increment primary key,
    user_id int not null,
    account_number varchar(20) not null unique,
    balance decimal(10, 2) not null default 0.00,
    created_at datetime not null default current_timestamp,
    updated_at datetime not null default current_timestamp on update current_timestamp,
    foreign key (user_id) references users(id)
);

create table transactions (
    id int auto_increment primary key,
    account_id int not null,
    type varchar(10) not null,
    amount decimal(10, 2) not null,
    description text,
    reference varchar(255),
    created_at datetime not null default current_timestamp,
    user_id int not null,
    foreign key (account_id) references accounts(id),
    foreign key (user_id) references users(id)
);

create table categories (
    id int auto_increment primary key,
    slug varchar(100) not null unique,
    name varchar(255) not null,
    icon varchar(100),
    color varchar(50),
    status tinyint(1) not null default 1,
    created_at timestamp default current_timestamp,
    updated_at timestamp default current_timestamp on update current_timestamp
);

create table products (
    id int auto_increment primary key,
    category_id int,
    name varchar(255) not null,
    price decimal(10, 2) not null,
    img varchar(255),
    status tinyint(1) not null default 1,
    created_at timestamp default current_timestamp,
    updated_at timestamp default current_timestamp on update current_timestamp,
    foreign key (category_id) references categories(id) on delete set null
);

create table orders (
    id int auto_increment primary key,
    order_number varchar(50) not null unique,
    status varchar(20) not null default 'completed', -- completed, held, cancelled
    subtotal decimal(10, 2) not null default 0.00,
    discount_type varchar(20), -- percent, fixed
    discount_value decimal(10, 2) default 0.00,
    discount_amount decimal(10, 2) default 0.00,
    tax_rate decimal(5, 2) default 0.00,
    tax_amount decimal(10, 2) default 0.00,
    total decimal(10, 2) not null default 0.00,
    payment_method varchar(50), -- cash, card, digital
    cash_received decimal(10, 2) default 0.00,
    cash_change decimal(10, 2) default 0.00,
    cashier_id int,
    created_at timestamp default current_timestamp,
    updated_at timestamp default current_timestamp on update current_timestamp,
    foreign key (cashier_id) references users(id) on delete set null
);

create table order_items (
    id int auto_increment primary key,
    order_id int not null,
    product_id int, -- can be null for custom items
    product_name varchar(255) not null,
    price decimal(10, 2) not null,
    quantity int not null default 1,
    line_total decimal(10, 2) not null,
    note text,
    is_custom tinyint(1) not null default 0,
    created_at timestamp default current_timestamp,
    updated_at timestamp default current_timestamp on update current_timestamp,
    foreign key (order_id) references orders(id) on delete cascade,
    foreign key (product_id) references products(id) on delete set null
);
