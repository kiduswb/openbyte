CREATE TABLE users (
    id TEXT PRIMARY KEY,
    email TEXT NOT NULL,
    pwd_hash TEXT NOT NULL,
    is_verified SMALLINT NOT NULL,
    timestamp INT NOT NULL
);

CREATE TABLE sites (
    id TEXT PRIMARY KEY,
    userid TEXT,
    label TEXT,
    subdomain TEXT,
    internal_id TEXT,
    cpanel_username TEXT,
    cpanel_password TEXT,
    timestamp INT
);

CREATE TABLE reset_tokens (
    userid VARCHAR(255) PRIMARY KEY,
    token VARCHAR(255) NOT NULL
);

