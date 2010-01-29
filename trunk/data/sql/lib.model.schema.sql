
-----------------------------------------------------------------------------
-- sf_guard_user_profile
-----------------------------------------------------------------------------

DROP TABLE "sf_guard_user_profile" CASCADE;


CREATE TABLE "sf_guard_user_profile"
(
	"user_id" INTEGER  NOT NULL,
	"first_name" VARCHAR(50),
	"last_name" VARCHAR(50),
	PRIMARY KEY ("user_id")
);

COMMENT ON TABLE "sf_guard_user_profile" IS '';


SET search_path TO public;
-----------------------------------------------------------------------------
-- picture
-----------------------------------------------------------------------------

DROP TABLE "picture" CASCADE;


CREATE TABLE "picture"
(
	"id" serial  NOT NULL,
	"path" VARCHAR(255),
	PRIMARY KEY ("id")
);

COMMENT ON TABLE "picture" IS '';


SET search_path TO public;
-----------------------------------------------------------------------------
-- description
-----------------------------------------------------------------------------

DROP TABLE "description" CASCADE;


CREATE TABLE "description"
(
	"id" serial  NOT NULL,
	"picture_id" INTEGER,
	"text" VARCHAR(255),
	PRIMARY KEY ("id")
);

COMMENT ON TABLE "description" IS '';


SET search_path TO public;
ALTER TABLE "sf_guard_user_profile" ADD CONSTRAINT "sf_guard_user_profile_FK_1" FOREIGN KEY ("user_id") REFERENCES "sf_guard_user" ("id") ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE "description" ADD CONSTRAINT "description_FK_1" FOREIGN KEY ("picture_id") REFERENCES "picture" ("id");
