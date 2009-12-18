
-----------------------------------------------------------------------------
-- sf_guard_user_profile
-----------------------------------------------------------------------------

DROP TABLE "sf_guard_user_profile" CASCADE;


CREATE TABLE "sf_guard_user_profile"
(
	"first_name" VARCHAR(50),
	"id" serial  NOT NULL,
	PRIMARY KEY ("id")
);

COMMENT ON TABLE "sf_guard_user_profile" IS '';


SET search_path TO public;