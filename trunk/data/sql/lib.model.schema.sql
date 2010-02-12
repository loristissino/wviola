
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
-- asset
-----------------------------------------------------------------------------

DROP TABLE "asset" CASCADE;


CREATE TABLE "asset"
(
	"id" serial  NOT NULL,
	"slug" VARCHAR(50)  NOT NULL,
	"status" INTEGER,
	"archive_id" INTEGER,
	"asset_type" INTEGER,
	"assigned_title" VARCHAR(255),
	"category_id" INTEGER,
	"notes" TEXT,
	"event_date" DATE,
	"source_filename" VARCHAR(255),
	"source_file_date" DATE,
	"highquality_md5sum" VARCHAR(32),
	"lowquality_md5sum" VARCHAR(32),
	"has_thumbnail" BOOLEAN,
	"thumbnail_width" INTEGER,
	"thumbnail_height" INTEGER,
	"thumbnail_size" INTEGER,
	"user_id" INTEGER  NOT NULL,
	"created_at" TIMESTAMP,
	"updated_at" TIMESTAMP,
	PRIMARY KEY ("id"),
	CONSTRAINT "asset_U_1" UNIQUE ("slug")
);

COMMENT ON TABLE "asset" IS '';


SET search_path TO public;
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
	"highquality_video_codec" VARCHAR(10),
	"highquality_audio_codec" VARCHAR(10),
	"highquality_frame_rate" INTEGER,
	"highquality_aspect_ratio" FLOAT,
	"lowquality_width" INTEGER,
	"lowquality_height" INTEGER,
	"lowquality_video_codec" VARCHAR(10),
	"lowquality_audio_codec" VARCHAR(10),
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
-- archive
-----------------------------------------------------------------------------

DROP TABLE "archive" CASCADE;


CREATE TABLE "archive"
(
	"id" serial  NOT NULL,
	"slug" VARCHAR(50),
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
ALTER TABLE "sf_guard_user_profile" ADD CONSTRAINT "sf_guard_user_profile_FK_1" FOREIGN KEY ("user_id") REFERENCES "sf_guard_user" ("id") ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE "asset" ADD CONSTRAINT "asset_FK_1" FOREIGN KEY ("archive_id") REFERENCES "archive" ("id");

ALTER TABLE "asset" ADD CONSTRAINT "asset_FK_2" FOREIGN KEY ("category_id") REFERENCES "category" ("id");

ALTER TABLE "asset" ADD CONSTRAINT "asset_FK_3" FOREIGN KEY ("user_id") REFERENCES "sf_guard_user_profile" ("user_id") ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE "video_asset" ADD CONSTRAINT "video_asset_FK_1" FOREIGN KEY ("asset_id") REFERENCES "asset" ("id") ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE "picture_asset" ADD CONSTRAINT "picture_asset_FK_1" FOREIGN KEY ("asset_id") REFERENCES "asset" ("id") ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE "photoalbum_asset" ADD CONSTRAINT "photoalbum_asset_FK_1" FOREIGN KEY ("asset_id") REFERENCES "asset" ("id") ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE "audio_asset" ADD CONSTRAINT "audio_asset_FK_1" FOREIGN KEY ("asset_id") REFERENCES "asset" ("id") ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE "archive" ADD CONSTRAINT "archive_FK_1" FOREIGN KEY ("user_id") REFERENCES "sf_guard_user_profile" ("user_id") ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE "access_log" ADD CONSTRAINT "access_log_FK_1" FOREIGN KEY ("asset_id") REFERENCES "asset" ("id");

ALTER TABLE "access_log" ADD CONSTRAINT "access_log_FK_2" FOREIGN KEY ("user_id") REFERENCES "sf_guard_user_profile" ("user_id") ON UPDATE CASCADE ON DELETE RESTRICT;
