CREATE DATABASE IF NOT EXISTS agenda;
USE agenda;

CREATE TABLE IF NOT EXISTS states (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ibge_id INT UNIQUE NOT NULL,
    name VARCHAR(100) NOT NULL,
    abbreviation CHAR(2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE INDEX idx_states_ibge_id ON states(ibge_id);
CREATE INDEX idx_states_abbreviation ON states(abbreviation);
CREATE INDEX idx_states_name ON states(name);

CREATE TABLE IF NOT EXISTS cities (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ibge_id INT UNIQUE,
    name VARCHAR(100) NOT NULL,
    state_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (state_id) REFERENCES states(id)
);

CREATE INDEX idx_cities_ibge_id ON cities(ibge_id);
CREATE INDEX idx_cities_state_id ON cities(state_id);
CREATE INDEX idx_cities_name ON cities(name);

CREATE TABLE IF NOT EXISTS contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    city_id INT NOT NULL,
    state_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (city_id) REFERENCES cities(id),
    FOREIGN KEY (state_id) REFERENCES states(id)
);

CREATE INDEX idx_contacts_city_id ON contacts(city_id);
CREATE INDEX idx_contacts_state_id ON contacts(state_id);
CREATE INDEX idx_contacts_name ON contacts(name);
CREATE INDEX idx_contacts_phone ON contacts(phone);