CREATE TABLE director_dictionary (
  id serial,
  dictionary_name character varying(255) NOT NULL,
  owner character varying(255) NOT NULL,
  PRIMARY KEY (id)
);

CREATE UNIQUE INDEX director_dictionary_unique_dictionary_name ON director_dictionary (dictionary_name);

CREATE TABLE director_dictionary_field (
  id serial,
  dictionary_id integer NOT NULL,
  varname character varying(64) NOT NULL,
  caption character varying(255) NOT NULL,
  description text DEFAULT NULL,
  datatype character varying(255) NOT NULL,
  format enum_property_format,
  is_required enum_boolean NOT NULL,
  allow_multiple enum_boolean NOT NULL,
  PRIMARY KEY (id),
  CONSTRAINT dictionary_field_dictionary
    FOREIGN KEY (dictionary_id)
    REFERENCES director_dictionary (id)
    ON DELETE CASCADE
    ON UPDATE CASCADE
);

CREATE TABLE director_dictionary_field_setting (
  dictionary_field_id integer NOT NULL,
  setting_name character varying(64) NOT NULL,
  setting_value text NOT NULL,
  PRIMARY KEY (dictionary_field_id, setting_name),
  CONSTRAINT dictfield_id_settings
    FOREIGN KEY (dictionary_field_id)
    REFERENCES director_dictionary_field (id)
    ON DELETE CASCADE
    ON UPDATE CASCADE
 );

INSERT INTO director_schema_migration
  (schema_version, migration_time)
  VALUES (110, NOW());
