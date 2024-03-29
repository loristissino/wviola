
-----------------------------------------------------------------------------
-- sf_guard_user_profile
-----------------------------------------------------------------------------

DROP TABLE "sf_guard_user_profile" CASCADE;


CREATE TABLE "sf_guard_user_profile"
(
	"user_id" INTEGER  NOT NULL,
	"first_name" VARCHAR(50),
	"last_name" VARCHAR(50),
	"email" VARCHAR(255),
	"imported_at" TIMESTAMP,
	"updated_at" TIMESTAMP,
	PRIMARY KEY ("user_id")
);

COMMENT ON TABLE "sf_guard_user_profile" IS '';


SET search_path TO public;
-----------------------------------------------------------------------------
-- asset
-----------------------------------------------------------------------------

DROP TABLE "asset" CASCADE;


CREATE TABLE "asset"
(
	"id" serial  NOT NULL,
	"uniqid" VARCHAR(50)  NOT NULL,
	"binder_id" INTEGER,
	"archive_id" INTEGER,
	"status" INTEGER,
	"asset_type" INTEGER,
	"notes" TEXT,
	"source_filename" VARCHAR(255),
	"source_file_datetime" TIMESTAMP,
	"source_size" INT8,
	"source_lmd5sum" VARCHAR(34),
	"highquality_md5sum" VARCHAR(32),
	"highquality_size" INT8,
	"lowquality_md5sum" VARCHAR(32),
	"lowquality_size" INT8,
	"has_thumbnail" BOOLEAN,
	"thumbnail_width" INTEGER,
	"thumbnail_height" INTEGER,
	"thumbnail_size" INTEGER,
	"thumbnail_position" FLOAT,
	"inode" INT8,
	"created_at" TIMESTAMP,
	"updated_at" TIMESTAMP,
	PRIMARY KEY ("id"),
	CONSTRAINT "asset_U_1" UNIQUE ("uniqid"),
	CONSTRAINT "sm" UNIQUE ("source_size","source_lmd5sum")
);

COMMENT ON TABLE "asset" IS '';


SET search_path TO public;
CREATE INDEX "asset_I_1" ON "asset" ("source_size");

CREATE INDEX "asset_I_2" ON "asset" ("source_lmd5sum");

CREATE INDEX "asset_I_3" ON "asset" ("highquality_size");

CREATE INDEX "asset_I_4" ON "asset" ("lowquality_size");

-----------------------------------------------------------------------------
-- video_asset
-----------------------------------------------------------------------------

DROP TABLE "video_asset" CASCADE;


CREATE TABLE "video_asset"
(
	"asset_id" INTEGER  NOT NULL,
	"duration" FLOAT,
	"highquality_width" INTEGER,
	"highquality_height" INTEGER,
	"highquality_video_codec" VARCHAR(20),
	"highquality_audio_codec" VARCHAR(20),
	"highquality_frame_rate" INTEGER,
	"highquality_aspect_ratio" FLOAT,
	"lowquality_width" INTEGER,
	"lowquality_height" INTEGER,
	"lowquality_video_codec" VARCHAR(20),
	"lowquality_audio_codec" VARCHAR(20),
	"lowquality_frame_rate" INTEGER,
	PRIMARY KEY ("asset_id")
);

COMMENT ON TABLE "video_asset" IS '';


SET search_path TO public;
-----------------------------------------------------------------------------
-- picture_asset
-----------------------------------------------------------------------------

DROP TABLE "picture_asset" CASCADE;


CREATE TABLE "picture_asset"
(
	"asset_id" INTEGER  NOT NULL,
	"highquality_width" INTEGER,
	"highquality_height" INTEGER,
	"highquality_picture_format" VARCHAR(10),
	"lowquality_width" INTEGER,
	"lowquality_height" INTEGER,
	"lowquality_picture_format" VARCHAR(10),
	PRIMARY KEY ("asset_id")
);

COMMENT ON TABLE "picture_asset" IS '';


SET search_path TO public;
-----------------------------------------------------------------------------
-- photoalbum_asset
-----------------------------------------------------------------------------

DROP TABLE "photoalbum_asset" CASCADE;


CREATE TABLE "photoalbum_asset"
(
	"asset_id" INTEGER  NOT NULL,
	"pictures_count" INTEGER,
	PRIMARY KEY ("asset_id")
);

COMMENT ON TABLE "photoalbum_asset" IS '';


SET search_path TO public;
-----------------------------------------------------------------------------
-- audio_asset
-----------------------------------------------------------------------------

DROP TABLE "audio_asset" CASCADE;


CREATE TABLE "audio_asset"
(
	"asset_id" INTEGER  NOT NULL,
	"duration" FLOAT,
	"highquality_audio_codec" VARCHAR(10),
	"lowquality_audio_codec" VARCHAR(10),
	PRIMARY KEY ("asset_id")
);

COMMENT ON TABLE "audio_asset" IS '';


SET search_path TO public;
-----------------------------------------------------------------------------
-- binder
-----------------------------------------------------------------------------

DROP TABLE "binder" CASCADE;


CREATE TABLE "binder"
(
	"id" serial  NOT NULL,
	"user_id" INTEGER  NOT NULL,
	"tagger_user_id" INTEGER,
	"category_id" INTEGER,
	"title" VARCHAR(255),
	"code" VARCHAR(25),
	"event_date" DATE,
	"is_open" BOOLEAN default 't',
	"archive_id" INTEGER,
	"created_at" TIMESTAMP,
	"updated_at" TIMESTAMP,
	PRIMARY KEY ("id")
);

COMMENT ON TABLE "binder" IS '';


SET search_path TO public;
-----------------------------------------------------------------------------
-- archive
-----------------------------------------------------------------------------

DROP TABLE "archive" CASCADE;


CREATE TABLE "archive"
(
	"id" serial  NOT NULL,
	"slug" VARCHAR(50),
	"archive_type" INTEGER,
	"position" INTEGER,
	"created_at" TIMESTAMP,
	"burned_at" TIMESTAMP,
	"user_id" INTEGER,
	"md5sum" VARCHAR(32),
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
	"id" serial  NOT NULL,
	"shortcut" VARCHAR(5),
	"name" VARCHAR(50),
	PRIMARY KEY ("id"),
	CONSTRAINT "category_U_1" UNIQUE ("shortcut")
);

COMMENT ON TABLE "category" IS '';


SET search_path TO public;
-----------------------------------------------------------------------------
-- access_log_event
-----------------------------------------------------------------------------

DROP TABLE "access_log_event" CASCADE;


CREATE TABLE "access_log_event"
(
	"id" serial  NOT NULL,
	"asset_id" INTEGER,
	"user_id" INTEGER  NOT NULL,
	"session" VARCHAR(32),
	"created_at" TIMESTAMP,
	PRIMARY KEY ("id"),
	CONSTRAINT "aus" UNIQUE ("asset_id","user_id","session")
);

COMMENT ON TABLE "access_log_event" IS '';


SET search_path TO public;
-----------------------------------------------------------------------------
-- task_log_event
-----------------------------------------------------------------------------

DROP TABLE "task_log_event" CASCADE;


CREATE TABLE "task_log_event"
(
	"id" serial  NOT NULL,
	"task_name" VARCHAR(50),
	"options" TEXT,
	"arguments" TEXT,
	"started_at" TIMESTAMP,
	"finished_at" TIMESTAMP,
	"task_exception" TEXT,
	PRIMARY KEY ("id")
);

COMMENT ON TABLE "task_log_event" IS '';


SET search_path TO public;
-----------------------------------------------------------------------------
-- source
-----------------------------------------------------------------------------

DROP TABLE "source" CASCADE;


CREATE TABLE "source"
(
	"id" serial  NOT NULL,
	"user_id" INTEGER  NOT NULL,
	"relative_path" VARCHAR(255)  NOT NULL,
	"basename" VARCHAR(255)  NOT NULL,
	"status" INTEGER,
	"inode" INT8,
	"task_log_event_id" INTEGER,
	"created_at" TIMESTAMP,
	PRIMARY KEY ("id")
);

COMMENT ON TABLE "source" IS '';


SET search_path TO public;
CREATE INDEX "source_I_1" ON "source" ("relative_path");

CREATE INDEX "source_I_2" ON "source" ("basename");

CREATE INDEX "pb" ON "source" ("relative_path","basename");

ALTER TABLE "sf_guard_user_profile" ADD CONSTRAINT "sf_guard_user_profile_FK_1" FOREIGN KEY ("user_id") REFERENCES "sf_guard_user" ("id") ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE "asset" ADD CONSTRAINT "asset_FK_1" FOREIGN KEY ("binder_id") REFERENCES "binder" ("id");

ALTER TABLE "asset" ADD CONSTRAINT "asset_FK_2" FOREIGN KEY ("archive_id") REFERENCES "archive" ("id");

ALTER TABLE "video_asset" ADD CONSTRAINT "video_asset_FK_1" FOREIGN KEY ("asset_id") REFERENCES "asset" ("id") ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE "picture_asset" ADD CONSTRAINT "picture_asset_FK_1" FOREIGN KEY ("asset_id") REFERENCES "asset" ("id") ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE "photoalbum_asset" ADD CONSTRAINT "photoalbum_asset_FK_1" FOREIGN KEY ("asset_id") REFERENCES "asset" ("id") ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE "audio_asset" ADD CONSTRAINT "audio_asset_FK_1" FOREIGN KEY ("asset_id") REFERENCES "asset" ("id") ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE "binder" ADD CONSTRAINT "binder_FK_1" FOREIGN KEY ("user_id") REFERENCES "sf_guard_user_profile" ("user_id") ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE "binder" ADD CONSTRAINT "binder_FK_2" FOREIGN KEY ("tagger_user_id") REFERENCES "sf_guard_user_profile" ("user_id") ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE "binder" ADD CONSTRAINT "binder_FK_3" FOREIGN KEY ("category_id") REFERENCES "category" ("id");

ALTER TABLE "binder" ADD CONSTRAINT "binder_FK_4" FOREIGN KEY ("archive_id") REFERENCES "archive" ("id");

ALTER TABLE "archive" ADD CONSTRAINT "archive_FK_1" FOREIGN KEY ("user_id") REFERENCES "sf_guard_user_profile" ("user_id") ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE "access_log_event" ADD CONSTRAINT "access_log_event_FK_1" FOREIGN KEY ("asset_id") REFERENCES "asset" ("id");

ALTER TABLE "access_log_event" ADD CONSTRAINT "access_log_event_FK_2" FOREIGN KEY ("user_id") REFERENCES "sf_guard_user_profile" ("user_id") ON UPDATE CASCADE ON DELETE RESTRICT;

ALTER TABLE "source" ADD CONSTRAINT "source_FK_1" FOREIGN KEY ("user_id") REFERENCES "sf_guard_user_profile" ("user_id") ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE "source" ADD CONSTRAINT "source_FK_2" FOREIGN KEY ("task_log_event_id") REFERENCES "task_log_event" ("id");
