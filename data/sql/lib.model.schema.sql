
-----------------------------------------------------------------------------
-- sf_guard_user_profile
-----------------------------------------------------------------------------

DROP TABLE "sf_guard_user_profile" CASCADE;


CREATE TABLE "sf_guard_user_profile"
(
	"user_id" INTEGER  NOT NULL,
	"first_name" VARCHAR(50),
	"last_name" VARCHAR(50),
	"imported_at" TIMESTAMP,
	PRIMARY KEY ("user_id")
);

COMMENT ON TABLE "sf_guard_user_profile" IS '';


SET search_path TO public;
-----------------------------------------------------------------------------
-- asset_type
-----------------------------------------------------------------------------

DROP TABLE "asset_type" CASCADE;


CREATE TABLE "asset_type"
(
	"id" serial  NOT NULL,
	"name" VARCHAR(255)  NOT NULL,
	"attributes" TEXT,
	PRIMARY KEY ("id"),
	CONSTRAINT "asset_type_U_1" UNIQUE ("name")
);

COMMENT ON TABLE "asset_type" IS '';


SET search_path TO public;
-----------------------------------------------------------------------------
-- asset
-----------------------------------------------------------------------------

DROP TABLE "asset" CASCADE;


CREATE TABLE "asset"
(
	"id" serial  NOT NULL,
	"slug" VARCHAR(50)  NOT NULL,
	"asset_type_id" INTEGER,
	"assigned_title" VARCHAR(255),
	"category_id" VARCHAR(5),
	"notes" TEXT,
	"frames_count" INTEGER,
	"source_filename" VARCHAR(255),
	"source_file_date" DATE,
	"highquality_width" INTEGER,
	"highquality_height" INTEGER,
	"highquality_video_codec" VARCHAR(10),
	"highquality_audio_codec" VARCHAR(10),
	"highquality_frame_rate" INTEGER,
	"highquality_md5sum" VARCHAR(32),
	"lowquality_width" INTEGER,
	"lowquality_height" INTEGER,
	"lowquality_video_codec" VARCHAR(10),
	"lowquality_audio_codec" VARCHAR(10),
	"lowquality_frame_rate" INTEGER,
	"lowquality_md5sum" VARCHAR(32),
	"user_id" INTEGER  NOT NULL,
	"created_at" TIMESTAMP,
	"updated_at" TIMESTAMP,
	PRIMARY KEY ("id"),
	CONSTRAINT "asset_U_1" UNIQUE ("slug")
);

COMMENT ON TABLE "asset" IS '';


SET search_path TO public;
-----------------------------------------------------------------------------
-- archive
-----------------------------------------------------------------------------

DROP TABLE "archive" CASCADE;


CREATE TABLE "archive"
(
	"id" serial  NOT NULL,
	"slug" VARCHAR(50),
	"created_at" TIMESTAMP,
	PRIMARY KEY ("id")
);

COMMENT ON TABLE "archive" IS '';


SET search_path TO public;
-----------------------------------------------------------------------------
-- category
-----------------------------------------------------------------------------

DROP TABLE "category" CASCADE;


CREATE TABLE "category"
(
	"id" VARCHAR(5)  NOT NULL,
	"name" VARCHAR(50),
	PRIMARY KEY ("id")
);

COMMENT ON TABLE "category" IS '';


SET search_path TO public;
-----------------------------------------------------------------------------
-- access_log
-----------------------------------------------------------------------------

DROP TABLE "access_log" CASCADE;


CREATE TABLE "access_log"
(
	"id" serial  NOT NULL,
	"asset_id" INTEGER,
	"user_id" INTEGER  NOT NULL,
	"created_at" TIMESTAMP,
	PRIMARY KEY ("id")
);

COMMENT ON TABLE "access_log" IS '';


SET search_path TO public;
-----------------------------------------------------------------------------
-- task_log
-----------------------------------------------------------------------------

DROP TABLE "task_log" CASCADE;


CREATE TABLE "task_log"
(
	"id" serial  NOT NULL,
	"task_type" INTEGER,
	"created_at" TIMESTAMP,
	"updated_at" TIMESTAMP,
	PRIMARY KEY ("id")
);

COMMENT ON TABLE "task_log" IS '';


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

ALTER TABLE "asset" ADD CONSTRAINT "asset_FK_1" FOREIGN KEY ("asset_type_id") REFERENCES "asset_type" ("id");

ALTER TABLE "asset" ADD CONSTRAINT "asset_FK_2" FOREIGN KEY ("category_id") REFERENCES "category" ("id");

ALTER TABLE "asset" ADD CONSTRAINT "asset_FK_3" FOREIGN KEY ("user_id") REFERENCES "sf_guard_user_profile" ("user_id") ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE "access_log" ADD CONSTRAINT "access_log_FK_1" FOREIGN KEY ("asset_id") REFERENCES "asset" ("id");

ALTER TABLE "access_log" ADD CONSTRAINT "access_log_FK_2" FOREIGN KEY ("user_id") REFERENCES "sf_guard_user_profile" ("user_id") ON UPDATE CASCADE ON DELETE RESTRICT;

ALTER TABLE "description" ADD CONSTRAINT "description_FK_1" FOREIGN KEY ("picture_id") REFERENCES "picture" ("id");
