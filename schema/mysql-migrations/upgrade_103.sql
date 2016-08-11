CREATE TABLE director_dictionary (
  id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  dictionary_name VARCHAR(255) NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY (dictionary_name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE director_dictionaryfield (
  id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  dictionary_id INT(10) UNSIGNED NOT NULL,
  datafield_id INT(10) UNSIGNED NOT NULL,
  dictionaryfield_name VARCHAR(255) NOT NULL,
  is_required ENUM('y','n') NOT NULL,
  allow_multiple ENUM('y','n') NOT NULL,
  PRIMARY KEY (id),
  CONSTRAINT dictionaryfield_dictionary
    FOREIGN KEY dictionary (dictionary_id)
    REFERENCES director_dictionary (id)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT dictionaryfield_datafield
    FOREIGN KEY datafield (datafield_id)
    REFERENCES director_datafield (id)
    ON DELETE RESTRICT
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO director_schema_migration
  (schema_version, migration_time)
  VALUES (103, NOW());
