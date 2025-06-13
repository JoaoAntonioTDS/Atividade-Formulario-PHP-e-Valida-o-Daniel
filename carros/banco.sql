CREATE TABLE carros (
    id INTEGER NOT NULL AUTO_INCREMENT,
    marca VARCHAR(20) NOT NULL,
    modelo VARCHAR(20) NOT NULL,
    motor VARCHAR(1) NOT NULL, -- E = Elétrico, C = Combustão, H = Híbrido
    cor VARCHAR(1) NOT NULL,   -- B, P, V, A, Z, E, C, R, M (códigos das cores)
    ano INTEGER NOT NULL,
    CONSTRAINT pk_carros PRIMARY KEY (id)
);