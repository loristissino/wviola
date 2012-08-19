<?php

/**
 * Base class that represents a row from the 'video_asset' table.
 *
 * 
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * Sat Aug 18 09:27:46 2012
 *
 * @package    lib.model.om
 */
abstract class BaseVideoAsset extends BaseObject  implements Persistent {


	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        VideoAssetPeer
	 */
	protected static $peer;

	/**
	 * The value for the asset_id field.
	 * @var        int
	 */
	protected $asset_id;

	/**
	 * The value for the duration field.
	 * @var        double
	 */
	protected $duration;

	/**
	 * The value for the highquality_width field.
	 * @var        int
	 */
	protected $highquality_width;

	/**
	 * The value for the highquality_height field.
	 * @var        int
	 */
	protected $highquality_height;

	/**
	 * The value for the highquality_video_codec field.
	 * @var        string
	 */
	protected $highquality_video_codec;

	/**
	 * The value for the highquality_audio_codec field.
	 * @var        string
	 */
	protected $highquality_audio_codec;

	/**
	 * The value for the highquality_frame_rate field.
	 * @var        int
	 */
	protected $highquality_frame_rate;

	/**
	 * The value for the highquality_aspect_ratio field.
	 * @var        double
	 */
	protected $highquality_aspect_ratio;

	/**
	 * The value for the lowquality_width field.
	 * @var        int
	 */
	protected $lowquality_width;

	/**
	 * The value for the lowquality_height field.
	 * @var        int
	 */
	protected $lowquality_height;

	/**
	 * The value for the lowquality_video_codec field.
	 * @var        string
	 */
	protected $lowquality_video_codec;

	/**
	 * The value for the lowquality_audio_codec field.
	 * @var        string
	 */
	protected $lowquality_audio_codec;

	/**
	 * The value for the lowquality_frame_rate field.
	 * @var        int
	 */
	protected $lowquality_frame_rate;

	/**
	 * @var        Asset
	 */
	protected $aAsset;

	/**
	 * Flag to prevent endless save loop, if this object is referenced
	 * by another object which falls in this transaction.
	 * @var        boolean
	 */
	protected $alreadyInSave = false;

	/**
	 * Flag to prevent endless validation loop, if this object is referenced
	 * by another object which falls in this transaction.
	 * @var        boolean
	 */
	protected $alreadyInValidation = false;

	// symfony behavior
	
	const PEER = 'VideoAssetPeer';

	/**
	 * Get the [asset_id] column value.
	 * 
	 * @return     int
	 */
	public function getAssetId()
	{
		return $this->asset_id;
	}

	/**
	 * Get the [duration] column value.
	 * 
	 * @return     double
	 */
	public function getDuration()
	{
		return $this->duration;
	}

	/**
	 * Get the [highquality_width] column value.
	 * 
	 * @return     int
	 */
	public function getHighqualityWidth()
	{
		return $this->highquality_width;
	}

	/**
	 * Get the [highquality_height] column value.
	 * 
	 * @return     int
	 */
	public function getHighqualityHeight()
	{
		return $this->highquality_height;
	}

	/**
	 * Get the [highquality_video_codec] column value.
	 * 
	 * @return     string
	 */
	public function getHighqualityVideoCodec()
	{
		return $this->highquality_video_codec;
	}

	/**
	 * Get the [highquality_audio_codec] column value.
	 * 
	 * @return     string
	 */
	public function getHighqualityAudioCodec()
	{
		return $this->highquality_audio_codec;
	}

	/**
	 * Get the [highquality_frame_rate] column value.
	 * 
	 * @return     int
	 */
	public function getHighqualityFrameRate()
	{
		return $this->highquality_frame_rate;
	}

	/**
	 * Get the [highquality_aspect_ratio] column value.
	 * 
	 * @return     double
	 */
	public function getHighqualityAspectRatio()
	{
		return $this->highquality_aspect_ratio;
	}

	/**
	 * Get the [lowquality_width] column value.
	 * 
	 * @return     int
	 */
	public function getLowqualityWidth()
	{
		return $this->lowquality_width;
	}

	/**
	 * Get the [lowquality_height] column value.
	 * 
	 * @return     int
	 */
	public function getLowqualityHeight()
	{
		return $this->lowquality_height;
	}

	/**
	 * Get the [lowquality_video_codec] column value.
	 * 
	 * @return     string
	 */
	public function getLowqualityVideoCodec()
	{
		return $this->lowquality_video_codec;
	}

	/**
	 * Get the [lowquality_audio_codec] column value.
	 * 
	 * @return     string
	 */
	public function getLowqualityAudioCodec()
	{
		return $this->lowquality_audio_codec;
	}

	/**
	 * Get the [lowquality_frame_rate] column value.
	 * 
	 * @return     int
	 */
	public function getLowqualityFrameRate()
	{
		return $this->lowquality_frame_rate;
	}

	/**
	 * Set the value of [asset_id] column.
	 * 
	 * @param      int $v new value
	 * @return     VideoAsset The current object (for fluent API support)
	 */
	public function setAssetId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->asset_id !== $v) {
			$this->asset_id = $v;
			$this->modifiedColumns[] = VideoAssetPeer::ASSET_ID;
		}

		if ($this->aAsset !== null && $this->aAsset->getId() !== $v) {
			$this->aAsset = null;
		}

		return $this;
	} // setAssetId()

	/**
	 * Set the value of [duration] column.
	 * 
	 * @param      double $v new value
	 * @return     VideoAsset The current object (for fluent API support)
	 */
	public function setDuration($v)
	{
		if ($v !== null) {
			$v = (double) $v;
		}

		if ($this->duration !== $v) {
			$this->duration = $v;
			$this->modifiedColumns[] = VideoAssetPeer::DURATION;
		}

		return $this;
	} // setDuration()

	/**
	 * Set the value of [highquality_width] column.
	 * 
	 * @param      int $v new value
	 * @return     VideoAsset The current object (for fluent API support)
	 */
	public function setHighqualityWidth($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->highquality_width !== $v) {
			$this->highquality_width = $v;
			$this->modifiedColumns[] = VideoAssetPeer::HIGHQUALITY_WIDTH;
		}

		return $this;
	} // setHighqualityWidth()

	/**
	 * Set the value of [highquality_height] column.
	 * 
	 * @param      int $v new value
	 * @return     VideoAsset The current object (for fluent API support)
	 */
	public function setHighqualityHeight($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->highquality_height !== $v) {
			$this->highquality_height = $v;
			$this->modifiedColumns[] = VideoAssetPeer::HIGHQUALITY_HEIGHT;
		}

		return $this;
	} // setHighqualityHeight()

	/**
	 * Set the value of [highquality_video_codec] column.
	 * 
	 * @param      string $v new value
	 * @return     VideoAsset The current object (for fluent API support)
	 */
	public function setHighqualityVideoCodec($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->highquality_video_codec !== $v) {
			$this->highquality_video_codec = $v;
			$this->modifiedColumns[] = VideoAssetPeer::HIGHQUALITY_VIDEO_CODEC;
		}

		return $this;
	} // setHighqualityVideoCodec()

	/**
	 * Set the value of [highquality_audio_codec] column.
	 * 
	 * @param      string $v new value
	 * @return     VideoAsset The current object (for fluent API support)
	 */
	public function setHighqualityAudioCodec($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->highquality_audio_codec !== $v) {
			$this->highquality_audio_codec = $v;
			$this->modifiedColumns[] = VideoAssetPeer::HIGHQUALITY_AUDIO_CODEC;
		}

		return $this;
	} // setHighqualityAudioCodec()

	/**
	 * Set the value of [highquality_frame_rate] column.
	 * 
	 * @param      int $v new value
	 * @return     VideoAsset The current object (for fluent API support)
	 */
	public function setHighqualityFrameRate($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->highquality_frame_rate !== $v) {
			$this->highquality_frame_rate = $v;
			$this->modifiedColumns[] = VideoAssetPeer::HIGHQUALITY_FRAME_RATE;
		}

		return $this;
	} // setHighqualityFrameRate()

	/**
	 * Set the value of [highquality_aspect_ratio] column.
	 * 
	 * @param      double $v new value
	 * @return     VideoAsset The current object (for fluent API support)
	 */
	public function setHighqualityAspectRatio($v)
	{
		if ($v !== null) {
			$v = (double) $v;
		}

		if ($this->highquality_aspect_ratio !== $v) {
			$this->highquality_aspect_ratio = $v;
			$this->modifiedColumns[] = VideoAssetPeer::HIGHQUALITY_ASPECT_RATIO;
		}

		return $this;
	} // setHighqualityAspectRatio()

	/**
	 * Set the value of [lowquality_width] column.
	 * 
	 * @param      int $v new value
	 * @return     VideoAsset The current object (for fluent API support)
	 */
	public function setLowqualityWidth($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->lowquality_width !== $v) {
			$this->lowquality_width = $v;
			$this->modifiedColumns[] = VideoAssetPeer::LOWQUALITY_WIDTH;
		}

		return $this;
	} // setLowqualityWidth()

	/**
	 * Set the value of [lowquality_height] column.
	 * 
	 * @param      int $v new value
	 * @return     VideoAsset The current object (for fluent API support)
	 */
	public function setLowqualityHeight($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->lowquality_height !== $v) {
			$this->lowquality_height = $v;
			$this->modifiedColumns[] = VideoAssetPeer::LOWQUALITY_HEIGHT;
		}

		return $this;
	} // setLowqualityHeight()

	/**
	 * Set the value of [lowquality_video_codec] column.
	 * 
	 * @param      string $v new value
	 * @return     VideoAsset The current object (for fluent API support)
	 */
	public function setLowqualityVideoCodec($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->lowquality_video_codec !== $v) {
			$this->lowquality_video_codec = $v;
			$this->modifiedColumns[] = VideoAssetPeer::LOWQUALITY_VIDEO_CODEC;
		}

		return $this;
	} // setLowqualityVideoCodec()

	/**
	 * Set the value of [lowquality_audio_codec] column.
	 * 
	 * @param      string $v new value
	 * @return     VideoAsset The current object (for fluent API support)
	 */
	public function setLowqualityAudioCodec($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->lowquality_audio_codec !== $v) {
			$this->lowquality_audio_codec = $v;
			$this->modifiedColumns[] = VideoAssetPeer::LOWQUALITY_AUDIO_CODEC;
		}

		return $this;
	} // setLowqualityAudioCodec()

	/**
	 * Set the value of [lowquality_frame_rate] column.
	 * 
	 * @param      int $v new value
	 * @return     VideoAsset The current object (for fluent API support)
	 */
	public function setLowqualityFrameRate($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->lowquality_frame_rate !== $v) {
			$this->lowquality_frame_rate = $v;
			$this->modifiedColumns[] = VideoAssetPeer::LOWQUALITY_FRAME_RATE;
		}

		return $this;
	} // setLowqualityFrameRate()

	/**
	 * Indicates whether the columns in this object are only set to default values.
	 *
	 * This method can be used in conjunction with isModified() to indicate whether an object is both
	 * modified _and_ has some values set which are non-default.
	 *
	 * @return     boolean Whether the columns in this object are only been set with default values.
	 */
	public function hasOnlyDefaultValues()
	{
		// otherwise, everything was equal, so return TRUE
		return true;
	} // hasOnlyDefaultValues()

	/**
	 * Hydrates (populates) the object variables with values from the database resultset.
	 *
	 * An offset (0-based "start column") is specified so that objects can be hydrated
	 * with a subset of the columns in the resultset rows.  This is needed, for example,
	 * for results of JOIN queries where the resultset row includes columns from two or
	 * more tables.
	 *
	 * @param      array $row The row returned by PDOStatement->fetch(PDO::FETCH_NUM)
	 * @param      int $startcol 0-based offset column which indicates which restultset column to start with.
	 * @param      boolean $rehydrate Whether this object is being re-hydrated from the database.
	 * @return     int next starting column
	 * @throws     PropelException  - Any caught Exception will be rewrapped as a PropelException.
	 */
	public function hydrate($row, $startcol = 0, $rehydrate = false)
	{
		try {

			$this->asset_id = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
			$this->duration = ($row[$startcol + 1] !== null) ? (double) $row[$startcol + 1] : null;
			$this->highquality_width = ($row[$startcol + 2] !== null) ? (int) $row[$startcol + 2] : null;
			$this->highquality_height = ($row[$startcol + 3] !== null) ? (int) $row[$startcol + 3] : null;
			$this->highquality_video_codec = ($row[$startcol + 4] !== null) ? (string) $row[$startcol + 4] : null;
			$this->highquality_audio_codec = ($row[$startcol + 5] !== null) ? (string) $row[$startcol + 5] : null;
			$this->highquality_frame_rate = ($row[$startcol + 6] !== null) ? (int) $row[$startcol + 6] : null;
			$this->highquality_aspect_ratio = ($row[$startcol + 7] !== null) ? (double) $row[$startcol + 7] : null;
			$this->lowquality_width = ($row[$startcol + 8] !== null) ? (int) $row[$startcol + 8] : null;
			$this->lowquality_height = ($row[$startcol + 9] !== null) ? (int) $row[$startcol + 9] : null;
			$this->lowquality_video_codec = ($row[$startcol + 10] !== null) ? (string) $row[$startcol + 10] : null;
			$this->lowquality_audio_codec = ($row[$startcol + 11] !== null) ? (string) $row[$startcol + 11] : null;
			$this->lowquality_frame_rate = ($row[$startcol + 12] !== null) ? (int) $row[$startcol + 12] : null;
			$this->resetModified();

			$this->setNew(false);

			if ($rehydrate) {
				$this->ensureConsistency();
			}

			// FIXME - using NUM_COLUMNS may be clearer.
			return $startcol + 13; // 13 = VideoAssetPeer::NUM_COLUMNS - VideoAssetPeer::NUM_LAZY_LOAD_COLUMNS).

		} catch (Exception $e) {
			throw new PropelException("Error populating VideoAsset object", $e);
		}
	}

	/**
	 * Checks and repairs the internal consistency of the object.
	 *
	 * This method is executed after an already-instantiated object is re-hydrated
	 * from the database.  It exists to check any foreign keys to make sure that
	 * the objects related to the current object are correct based on foreign key.
	 *
	 * You can override this method in the stub class, but you should always invoke
	 * the base method from the overridden method (i.e. parent::ensureConsistency()),
	 * in case your model changes.
	 *
	 * @throws     PropelException
	 */
	public function ensureConsistency()
	{

		if ($this->aAsset !== null && $this->asset_id !== $this->aAsset->getId()) {
			$this->aAsset = null;
		}
	} // ensureConsistency

	/**
	 * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
	 *
	 * This will only work if the object has been saved and has a valid primary key set.
	 *
	 * @param      boolean $deep (optional) Whether to also de-associated any related objects.
	 * @param      PropelPDO $con (optional) The PropelPDO connection to use.
	 * @return     void
	 * @throws     PropelException - if this object is deleted, unsaved or doesn't have pk match in db
	 */
	public function reload($deep = false, PropelPDO $con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("Cannot reload a deleted object.");
		}

		if ($this->isNew()) {
			throw new PropelException("Cannot reload an unsaved object.");
		}

		if ($con === null) {
			$con = Propel::getConnection(VideoAssetPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		// We don't need to alter the object instance pool; we're just modifying this instance
		// already in the pool.

		$stmt = VideoAssetPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
		$row = $stmt->fetch(PDO::FETCH_NUM);
		$stmt->closeCursor();
		if (!$row) {
			throw new PropelException('Cannot find matching row in the database to reload object values.');
		}
		$this->hydrate($row, 0, true); // rehydrate

		if ($deep) {  // also de-associate any related objects?

			$this->aAsset = null;
		} // if (deep)
	}

	/**
	 * Removes this object from datastore and sets delete attribute.
	 *
	 * @param      PropelPDO $con
	 * @return     void
	 * @throws     PropelException
	 * @see        BaseObject::setDeleted()
	 * @see        BaseObject::isDeleted()
	 */
	public function delete(PropelPDO $con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(VideoAssetPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		try {
			$ret = $this->preDelete($con);
			// symfony_behaviors behavior
			foreach (sfMixer::getCallables('BaseVideoAsset:delete:pre') as $callable)
			{
			  if (call_user_func($callable, $this, $con))
			  {
			    $con->commit();
			
			    return;
			  }
			}

			if ($ret) {
				VideoAssetPeer::doDelete($this, $con);
				$this->postDelete($con);
				// symfony_behaviors behavior
				foreach (sfMixer::getCallables('BaseVideoAsset:delete:post') as $callable)
				{
				  call_user_func($callable, $this, $con);
				}

				$this->setDeleted(true);
				$con->commit();
			} else {
				$con->commit();
			}
		} catch (PropelException $e) {
			$con->rollBack();
			throw $e;
		}
	}

	/**
	 * Persists this object to the database.
	 *
	 * If the object is new, it inserts it; otherwise an update is performed.
	 * All modified related objects will also be persisted in the doSave()
	 * method.  This method wraps all precipitate database operations in a
	 * single transaction.
	 *
	 * @param      PropelPDO $con
	 * @return     int The number of rows affected by this insert/update and any referring fk objects' save() operations.
	 * @throws     PropelException
	 * @see        doSave()
	 */
	public function save(PropelPDO $con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(VideoAssetPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		$isInsert = $this->isNew();
		try {
			$ret = $this->preSave($con);
			// symfony_behaviors behavior
			foreach (sfMixer::getCallables('BaseVideoAsset:save:pre') as $callable)
			{
			  if (is_integer($affectedRows = call_user_func($callable, $this, $con)))
			  {
			    $con->commit();
			
			    return $affectedRows;
			  }
			}

			if ($isInsert) {
				$ret = $ret && $this->preInsert($con);
			} else {
				$ret = $ret && $this->preUpdate($con);
			}
			if ($ret) {
				$affectedRows = $this->doSave($con);
				if ($isInsert) {
					$this->postInsert($con);
				} else {
					$this->postUpdate($con);
				}
				$this->postSave($con);
				// symfony_behaviors behavior
				foreach (sfMixer::getCallables('BaseVideoAsset:save:post') as $callable)
				{
				  call_user_func($callable, $this, $con, $affectedRows);
				}

				VideoAssetPeer::addInstanceToPool($this);
			} else {
				$affectedRows = 0;
			}
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollBack();
			throw $e;
		}
	}

	/**
	 * Performs the work of inserting or updating the row in the database.
	 *
	 * If the object is new, it inserts it; otherwise an update is performed.
	 * All related objects are also updated in this method.
	 *
	 * @param      PropelPDO $con
	 * @return     int The number of rows affected by this insert/update and any referring fk objects' save() operations.
	 * @throws     PropelException
	 * @see        save()
	 */
	protected function doSave(PropelPDO $con)
	{
		$affectedRows = 0; // initialize var to track total num of affected rows
		if (!$this->alreadyInSave) {
			$this->alreadyInSave = true;

			// We call the save method on the following object(s) if they
			// were passed to this object by their coresponding set
			// method.  This object relates to these object(s) by a
			// foreign key reference.

			if ($this->aAsset !== null) {
				if ($this->aAsset->isModified() || $this->aAsset->isNew()) {
					$affectedRows += $this->aAsset->save($con);
				}
				$this->setAsset($this->aAsset);
			}


			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = VideoAssetPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setNew(false);
				} else {
					$affectedRows += VideoAssetPeer::doUpdate($this, $con);
				}

				$this->resetModified(); // [HL] After being saved an object is no longer 'modified'
			}

			$this->alreadyInSave = false;

		}
		return $affectedRows;
	} // doSave()

	/**
	 * Array of ValidationFailed objects.
	 * @var        array ValidationFailed[]
	 */
	protected $validationFailures = array();

	/**
	 * Gets any ValidationFailed objects that resulted from last call to validate().
	 *
	 *
	 * @return     array ValidationFailed[]
	 * @see        validate()
	 */
	public function getValidationFailures()
	{
		return $this->validationFailures;
	}

	/**
	 * Validates the objects modified field values and all objects related to this table.
	 *
	 * If $columns is either a column name or an array of column names
	 * only those columns are validated.
	 *
	 * @param      mixed $columns Column name or an array of column names.
	 * @return     boolean Whether all columns pass validation.
	 * @see        doValidate()
	 * @see        getValidationFailures()
	 */
	public function validate($columns = null)
	{
		$res = $this->doValidate($columns);
		if ($res === true) {
			$this->validationFailures = array();
			return true;
		} else {
			$this->validationFailures = $res;
			return false;
		}
	}

	/**
	 * This function performs the validation work for complex object models.
	 *
	 * In addition to checking the current object, all related objects will
	 * also be validated.  If all pass then <code>true</code> is returned; otherwise
	 * an aggreagated array of ValidationFailed objects will be returned.
	 *
	 * @param      array $columns Array of column names to validate.
	 * @return     mixed <code>true</code> if all validations pass; array of <code>ValidationFailed</code> objets otherwise.
	 */
	protected function doValidate($columns = null)
	{
		if (!$this->alreadyInValidation) {
			$this->alreadyInValidation = true;
			$retval = null;

			$failureMap = array();


			// We call the validate method on the following object(s) if they
			// were passed to this object by their coresponding set
			// method.  This object relates to these object(s) by a
			// foreign key reference.

			if ($this->aAsset !== null) {
				if (!$this->aAsset->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aAsset->getValidationFailures());
				}
			}


			if (($retval = VideoAssetPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	/**
	 * Retrieves a field from the object by name passed in as a string.
	 *
	 * @param      string $name name
	 * @param      string $type The type of fieldname the $name is of:
	 *                     one of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
	 *                     BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM
	 * @return     mixed Value of field.
	 */
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = VideoAssetPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		$field = $this->getByPosition($pos);
		return $field;
	}

	/**
	 * Retrieves a field from the object by Position as specified in the xml schema.
	 * Zero-based.
	 *
	 * @param      int $pos position in xml schema
	 * @return     mixed Value of field at $pos
	 */
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getAssetId();
				break;
			case 1:
				return $this->getDuration();
				break;
			case 2:
				return $this->getHighqualityWidth();
				break;
			case 3:
				return $this->getHighqualityHeight();
				break;
			case 4:
				return $this->getHighqualityVideoCodec();
				break;
			case 5:
				return $this->getHighqualityAudioCodec();
				break;
			case 6:
				return $this->getHighqualityFrameRate();
				break;
			case 7:
				return $this->getHighqualityAspectRatio();
				break;
			case 8:
				return $this->getLowqualityWidth();
				break;
			case 9:
				return $this->getLowqualityHeight();
				break;
			case 10:
				return $this->getLowqualityVideoCodec();
				break;
			case 11:
				return $this->getLowqualityAudioCodec();
				break;
			case 12:
				return $this->getLowqualityFrameRate();
				break;
			default:
				return null;
				break;
		} // switch()
	}

	/**
	 * Exports the object as an array.
	 *
	 * You can specify the key type of the array by passing one of the class
	 * type constants.
	 *
	 * @param      string $keyType (optional) One of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
	 *                        BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM. Defaults to BasePeer::TYPE_PHPNAME.
	 * @param      boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns.  Defaults to TRUE.
	 * @return     an associative array containing the field names (as keys) and field values
	 */
	public function toArray($keyType = BasePeer::TYPE_PHPNAME, $includeLazyLoadColumns = true)
	{
		$keys = VideoAssetPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getAssetId(),
			$keys[1] => $this->getDuration(),
			$keys[2] => $this->getHighqualityWidth(),
			$keys[3] => $this->getHighqualityHeight(),
			$keys[4] => $this->getHighqualityVideoCodec(),
			$keys[5] => $this->getHighqualityAudioCodec(),
			$keys[6] => $this->getHighqualityFrameRate(),
			$keys[7] => $this->getHighqualityAspectRatio(),
			$keys[8] => $this->getLowqualityWidth(),
			$keys[9] => $this->getLowqualityHeight(),
			$keys[10] => $this->getLowqualityVideoCodec(),
			$keys[11] => $this->getLowqualityAudioCodec(),
			$keys[12] => $this->getLowqualityFrameRate(),
		);
		return $result;
	}

	/**
	 * Sets a field from the object by name passed in as a string.
	 *
	 * @param      string $name peer name
	 * @param      mixed $value field value
	 * @param      string $type The type of fieldname the $name is of:
	 *                     one of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
	 *                     BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM
	 * @return     void
	 */
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = VideoAssetPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	/**
	 * Sets a field from the object by Position as specified in the xml schema.
	 * Zero-based.
	 *
	 * @param      int $pos position in xml schema
	 * @param      mixed $value field value
	 * @return     void
	 */
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setAssetId($value);
				break;
			case 1:
				$this->setDuration($value);
				break;
			case 2:
				$this->setHighqualityWidth($value);
				break;
			case 3:
				$this->setHighqualityHeight($value);
				break;
			case 4:
				$this->setHighqualityVideoCodec($value);
				break;
			case 5:
				$this->setHighqualityAudioCodec($value);
				break;
			case 6:
				$this->setHighqualityFrameRate($value);
				break;
			case 7:
				$this->setHighqualityAspectRatio($value);
				break;
			case 8:
				$this->setLowqualityWidth($value);
				break;
			case 9:
				$this->setLowqualityHeight($value);
				break;
			case 10:
				$this->setLowqualityVideoCodec($value);
				break;
			case 11:
				$this->setLowqualityAudioCodec($value);
				break;
			case 12:
				$this->setLowqualityFrameRate($value);
				break;
		} // switch()
	}

	/**
	 * Populates the object using an array.
	 *
	 * This is particularly useful when populating an object from one of the
	 * request arrays (e.g. $_POST).  This method goes through the column
	 * names, checking to see whether a matching key exists in populated
	 * array. If so the setByName() method is called for that column.
	 *
	 * You can specify the key type of the array by additionally passing one
	 * of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME,
	 * BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
	 * The default key type is the column's phpname (e.g. 'AuthorId')
	 *
	 * @param      array  $arr     An array to populate the object from.
	 * @param      string $keyType The type of keys the array uses.
	 * @return     void
	 */
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = VideoAssetPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setAssetId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setDuration($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setHighqualityWidth($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setHighqualityHeight($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setHighqualityVideoCodec($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setHighqualityAudioCodec($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setHighqualityFrameRate($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setHighqualityAspectRatio($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setLowqualityWidth($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setLowqualityHeight($arr[$keys[9]]);
		if (array_key_exists($keys[10], $arr)) $this->setLowqualityVideoCodec($arr[$keys[10]]);
		if (array_key_exists($keys[11], $arr)) $this->setLowqualityAudioCodec($arr[$keys[11]]);
		if (array_key_exists($keys[12], $arr)) $this->setLowqualityFrameRate($arr[$keys[12]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(VideoAssetPeer::DATABASE_NAME);

		if ($this->isColumnModified(VideoAssetPeer::ASSET_ID)) $criteria->add(VideoAssetPeer::ASSET_ID, $this->asset_id);
		if ($this->isColumnModified(VideoAssetPeer::DURATION)) $criteria->add(VideoAssetPeer::DURATION, $this->duration);
		if ($this->isColumnModified(VideoAssetPeer::HIGHQUALITY_WIDTH)) $criteria->add(VideoAssetPeer::HIGHQUALITY_WIDTH, $this->highquality_width);
		if ($this->isColumnModified(VideoAssetPeer::HIGHQUALITY_HEIGHT)) $criteria->add(VideoAssetPeer::HIGHQUALITY_HEIGHT, $this->highquality_height);
		if ($this->isColumnModified(VideoAssetPeer::HIGHQUALITY_VIDEO_CODEC)) $criteria->add(VideoAssetPeer::HIGHQUALITY_VIDEO_CODEC, $this->highquality_video_codec);
		if ($this->isColumnModified(VideoAssetPeer::HIGHQUALITY_AUDIO_CODEC)) $criteria->add(VideoAssetPeer::HIGHQUALITY_AUDIO_CODEC, $this->highquality_audio_codec);
		if ($this->isColumnModified(VideoAssetPeer::HIGHQUALITY_FRAME_RATE)) $criteria->add(VideoAssetPeer::HIGHQUALITY_FRAME_RATE, $this->highquality_frame_rate);
		if ($this->isColumnModified(VideoAssetPeer::HIGHQUALITY_ASPECT_RATIO)) $criteria->add(VideoAssetPeer::HIGHQUALITY_ASPECT_RATIO, $this->highquality_aspect_ratio);
		if ($this->isColumnModified(VideoAssetPeer::LOWQUALITY_WIDTH)) $criteria->add(VideoAssetPeer::LOWQUALITY_WIDTH, $this->lowquality_width);
		if ($this->isColumnModified(VideoAssetPeer::LOWQUALITY_HEIGHT)) $criteria->add(VideoAssetPeer::LOWQUALITY_HEIGHT, $this->lowquality_height);
		if ($this->isColumnModified(VideoAssetPeer::LOWQUALITY_VIDEO_CODEC)) $criteria->add(VideoAssetPeer::LOWQUALITY_VIDEO_CODEC, $this->lowquality_video_codec);
		if ($this->isColumnModified(VideoAssetPeer::LOWQUALITY_AUDIO_CODEC)) $criteria->add(VideoAssetPeer::LOWQUALITY_AUDIO_CODEC, $this->lowquality_audio_codec);
		if ($this->isColumnModified(VideoAssetPeer::LOWQUALITY_FRAME_RATE)) $criteria->add(VideoAssetPeer::LOWQUALITY_FRAME_RATE, $this->lowquality_frame_rate);

		return $criteria;
	}

	/**
	 * Builds a Criteria object containing the primary key for this object.
	 *
	 * Unlike buildCriteria() this method includes the primary key values regardless
	 * of whether or not they have been modified.
	 *
	 * @return     Criteria The Criteria object containing value(s) for primary key(s).
	 */
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(VideoAssetPeer::DATABASE_NAME);

		$criteria->add(VideoAssetPeer::ASSET_ID, $this->asset_id);

		return $criteria;
	}

	/**
	 * Returns the primary key for this object (row).
	 * @return     int
	 */
	public function getPrimaryKey()
	{
		return $this->getAssetId();
	}

	/**
	 * Generic method to set the primary key (asset_id column).
	 *
	 * @param      int $key Primary key.
	 * @return     void
	 */
	public function setPrimaryKey($key)
	{
		$this->setAssetId($key);
	}

	/**
	 * Sets contents of passed object to values from current object.
	 *
	 * If desired, this method can also make copies of all associated (fkey referrers)
	 * objects.
	 *
	 * @param      object $copyObj An object of VideoAsset (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setAssetId($this->asset_id);

		$copyObj->setDuration($this->duration);

		$copyObj->setHighqualityWidth($this->highquality_width);

		$copyObj->setHighqualityHeight($this->highquality_height);

		$copyObj->setHighqualityVideoCodec($this->highquality_video_codec);

		$copyObj->setHighqualityAudioCodec($this->highquality_audio_codec);

		$copyObj->setHighqualityFrameRate($this->highquality_frame_rate);

		$copyObj->setHighqualityAspectRatio($this->highquality_aspect_ratio);

		$copyObj->setLowqualityWidth($this->lowquality_width);

		$copyObj->setLowqualityHeight($this->lowquality_height);

		$copyObj->setLowqualityVideoCodec($this->lowquality_video_codec);

		$copyObj->setLowqualityAudioCodec($this->lowquality_audio_codec);

		$copyObj->setLowqualityFrameRate($this->lowquality_frame_rate);


		$copyObj->setNew(true);

	}

	/**
	 * Makes a copy of this object that will be inserted as a new row in table when saved.
	 * It creates a new object filling in the simple attributes, but skipping any primary
	 * keys that are defined for the table.
	 *
	 * If desired, this method can also make copies of all associated (fkey referrers)
	 * objects.
	 *
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @return     VideoAsset Clone of current object.
	 * @throws     PropelException
	 */
	public function copy($deepCopy = false)
	{
		// we use get_class(), because this might be a subclass
		$clazz = get_class($this);
		$copyObj = new $clazz();
		$this->copyInto($copyObj, $deepCopy);
		return $copyObj;
	}

	/**
	 * Returns a peer instance associated with this om.
	 *
	 * Since Peer classes are not to have any instance attributes, this method returns the
	 * same instance for all member of this class. The method could therefore
	 * be static, but this would prevent one from overriding the behavior.
	 *
	 * @return     VideoAssetPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new VideoAssetPeer();
		}
		return self::$peer;
	}

	/**
	 * Declares an association between this object and a Asset object.
	 *
	 * @param      Asset $v
	 * @return     VideoAsset The current object (for fluent API support)
	 * @throws     PropelException
	 */
	public function setAsset(Asset $v = null)
	{
		if ($v === null) {
			$this->setAssetId(NULL);
		} else {
			$this->setAssetId($v->getId());
		}

		$this->aAsset = $v;

		// Add binding for other direction of this 1:1 relationship.
		if ($v !== null) {
			$v->setVideoAsset($this);
		}

		return $this;
	}


	/**
	 * Get the associated Asset object
	 *
	 * @param      PropelPDO Optional Connection object.
	 * @return     Asset The associated Asset object.
	 * @throws     PropelException
	 */
	public function getAsset(PropelPDO $con = null)
	{
		if ($this->aAsset === null && ($this->asset_id !== null)) {
			$this->aAsset = AssetPeer::retrieveByPk($this->asset_id);
			// Because this foreign key represents a one-to-one relationship, we will create a bi-directional association.
			$this->aAsset->setVideoAsset($this);
		}
		return $this->aAsset;
	}

	/**
	 * Resets all collections of referencing foreign keys.
	 *
	 * This method is a user-space workaround for PHP's inability to garbage collect objects
	 * with circular references.  This is currently necessary when using Propel in certain
	 * daemon or large-volumne/high-memory operations.
	 *
	 * @param      boolean $deep Whether to also clear the references on all associated objects.
	 */
	public function clearAllReferences($deep = false)
	{
		if ($deep) {
		} // if ($deep)

			$this->aAsset = null;
	}

	// symfony_behaviors behavior
	
	/**
	 * Calls methods defined via {@link sfMixer}.
	 */
	public function __call($method, $arguments)
	{
	  if (!$callable = sfMixer::getCallable('BaseVideoAsset:'.$method))
	  {
	    throw new sfException(sprintf('Call to undefined method BaseVideoAsset::%s', $method));
	  }
	
	  array_unshift($arguments, $this);
	
	  return call_user_func_array($callable, $arguments);
	}

} // BaseVideoAsset
