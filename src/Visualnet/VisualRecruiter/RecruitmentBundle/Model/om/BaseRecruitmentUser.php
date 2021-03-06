<?php

namespace Visualnet\VisualRecruiter\RecruitmentBundle\Model\om;

use \BaseObject;
use \BasePeer;
use \Criteria;
use \DateTime;
use \DateTimeZone;
use \Exception;
use \PDO;
use \Persistent;
use \Propel;
use \PropelCollection;
use \PropelDateTime;
use \PropelException;
use \PropelObjectCollection;
use \PropelPDO;
use Visualnet\VisualRecruiter\RecruitmentBundle\Model\Recruitment;
use Visualnet\VisualRecruiter\RecruitmentBundle\Model\RecruitmentDate;
use Visualnet\VisualRecruiter\RecruitmentBundle\Model\RecruitmentDateQuery;
use Visualnet\VisualRecruiter\RecruitmentBundle\Model\RecruitmentQuery;
use Visualnet\VisualRecruiter\RecruitmentBundle\Model\RecruitmentUserData;
use Visualnet\VisualRecruiter\RecruitmentBundle\Model\RecruitmentUserDataQuery;
use Visualnet\VisualRecruiter\RecruitmentBundle\Model\RecruitmentUserPeer;
use Visualnet\VisualRecruiter\RecruitmentBundle\Model\RecruitmentUserQuery;

/**
 * Base class that represents a row from the 'visual_recruitment_user' table.
 *
 * 
 *
 * @package    propel.generator.src.Visualnet.VisualRecruiter.RecruitmentBundle.Model.om
 */
abstract class BaseRecruitmentUser extends BaseObject  implements Persistent
{

	/**
	 * Peer class name
	 */
	const PEER = 'Visualnet\\VisualRecruiter\\RecruitmentBundle\\Model\\RecruitmentUserPeer';

	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        RecruitmentUserPeer
	 */
	protected static $peer;

	/**
	 * The flag var to prevent infinit loop in deep copy
	 * @var       boolean
	 */
	protected $startCopy = false;

	/**
	 * The value for the id field.
	 * @var        int
	 */
	protected $id;

	/**
	 * The value for the recruitment_id field.
	 * @var        int
	 */
	protected $recruitment_id;

	/**
	 * The value for the recruitment_date_id field.
	 * @var        int
	 */
	protected $recruitment_date_id;

	/**
	 * The value for the name field.
	 * @var        string
	 */
	protected $name;

	/**
	 * The value for the surname field.
	 * @var        string
	 */
	protected $surname;

	/**
	 * The value for the email field.
	 * @var        string
	 */
	protected $email;

	/**
	 * The value for the is_qualify field.
	 * Note: this column has a database default value of: false
	 * @var        boolean
	 */
	protected $is_qualify;

	/**
	 * The value for the is_active field.
	 * Note: this column has a database default value of: false
	 * @var        boolean
	 */
	protected $is_active;

	/**
	 * The value for the created_at field.
	 * @var        string
	 */
	protected $created_at;

	/**
	 * The value for the updated_at field.
	 * @var        string
	 */
	protected $updated_at;

	/**
	 * @var        Recruitment
	 */
	protected $aRecruitment;

	/**
	 * @var        RecruitmentDate
	 */
	protected $aRecruitmentDate;

	/**
	 * @var        array RecruitmentUserData[] Collection to store aggregation of RecruitmentUserData objects.
	 */
	protected $collRecruitmentUserDatas;

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

	/**
	 * An array of objects scheduled for deletion.
	 * @var		array
	 */
	protected $recruitmentUserDatasScheduledForDeletion = null;

	/**
	 * Applies default values to this object.
	 * This method should be called from the object's constructor (or
	 * equivalent initialization method).
	 * @see        __construct()
	 */
	public function applyDefaultValues()
	{
		$this->is_qualify = false;
		$this->is_active = false;
	}

	/**
	 * Initializes internal state of BaseRecruitmentUser object.
	 * @see        applyDefaults()
	 */
	public function __construct()
	{
		parent::__construct();
		$this->applyDefaultValues();
	}

	/**
	 * Get the [id] column value.
	 * 
	 * @return     int
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * Get the [recruitment_id] column value.
	 * 
	 * @return     int
	 */
	public function getRecruitmentId()
	{
		return $this->recruitment_id;
	}

	/**
	 * Get the [recruitment_date_id] column value.
	 * 
	 * @return     int
	 */
	public function getRecruitmentDateId()
	{
		return $this->recruitment_date_id;
	}

	/**
	 * Get the [name] column value.
	 * 
	 * @return     string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * Get the [surname] column value.
	 * 
	 * @return     string
	 */
	public function getSurname()
	{
		return $this->surname;
	}

	/**
	 * Get the [email] column value.
	 * 
	 * @return     string
	 */
	public function getEmail()
	{
		return $this->email;
	}

	/**
	 * Get the [is_qualify] column value.
	 * 
	 * @return     boolean
	 */
	public function getIsQualify()
	{
		return $this->is_qualify;
	}

	/**
	 * Get the [is_active] column value.
	 * 
	 * @return     boolean
	 */
	public function getIsActive()
	{
		return $this->is_active;
	}

	/**
	 * Get the [optionally formatted] temporal [created_at] column value.
	 * 
	 *
	 * @param      string $format The date/time format string (either date()-style or strftime()-style).
	 *							If format is NULL, then the raw DateTime object will be returned.
	 * @return     mixed Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
	 * @throws     PropelException - if unable to parse/validate the date/time value.
	 */
	public function getCreatedAt($format = NULL)
	{
		if ($this->created_at === null) {
			return null;
		}


		if ($this->created_at === '0000-00-00 00:00:00') {
			// while technically this is not a default value of NULL,
			// this seems to be closest in meaning.
			return null;
		} else {
			try {
				$dt = new DateTime($this->created_at);
			} catch (Exception $x) {
				throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->created_at, true), $x);
			}
		}

		if ($format === null) {
			// Because propel.useDateTimeClass is TRUE, we return a DateTime object.
			return $dt;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $dt->format('U'));
		} else {
			return $dt->format($format);
		}
	}

	/**
	 * Get the [optionally formatted] temporal [updated_at] column value.
	 * 
	 *
	 * @param      string $format The date/time format string (either date()-style or strftime()-style).
	 *							If format is NULL, then the raw DateTime object will be returned.
	 * @return     mixed Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
	 * @throws     PropelException - if unable to parse/validate the date/time value.
	 */
	public function getUpdatedAt($format = NULL)
	{
		if ($this->updated_at === null) {
			return null;
		}


		if ($this->updated_at === '0000-00-00 00:00:00') {
			// while technically this is not a default value of NULL,
			// this seems to be closest in meaning.
			return null;
		} else {
			try {
				$dt = new DateTime($this->updated_at);
			} catch (Exception $x) {
				throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->updated_at, true), $x);
			}
		}

		if ($format === null) {
			// Because propel.useDateTimeClass is TRUE, we return a DateTime object.
			return $dt;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $dt->format('U'));
		} else {
			return $dt->format($format);
		}
	}

	/**
	 * Set the value of [id] column.
	 * 
	 * @param      int $v new value
	 * @return     RecruitmentUser The current object (for fluent API support)
	 */
	public function setId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = RecruitmentUserPeer::ID;
		}

		return $this;
	} // setId()

	/**
	 * Set the value of [recruitment_id] column.
	 * 
	 * @param      int $v new value
	 * @return     RecruitmentUser The current object (for fluent API support)
	 */
	public function setRecruitmentId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->recruitment_id !== $v) {
			$this->recruitment_id = $v;
			$this->modifiedColumns[] = RecruitmentUserPeer::RECRUITMENT_ID;
		}

		if ($this->aRecruitment !== null && $this->aRecruitment->getId() !== $v) {
			$this->aRecruitment = null;
		}

		return $this;
	} // setRecruitmentId()

	/**
	 * Set the value of [recruitment_date_id] column.
	 * 
	 * @param      int $v new value
	 * @return     RecruitmentUser The current object (for fluent API support)
	 */
	public function setRecruitmentDateId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->recruitment_date_id !== $v) {
			$this->recruitment_date_id = $v;
			$this->modifiedColumns[] = RecruitmentUserPeer::RECRUITMENT_DATE_ID;
		}

		if ($this->aRecruitmentDate !== null && $this->aRecruitmentDate->getId() !== $v) {
			$this->aRecruitmentDate = null;
		}

		return $this;
	} // setRecruitmentDateId()

	/**
	 * Set the value of [name] column.
	 * 
	 * @param      string $v new value
	 * @return     RecruitmentUser The current object (for fluent API support)
	 */
	public function setName($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->name !== $v) {
			$this->name = $v;
			$this->modifiedColumns[] = RecruitmentUserPeer::NAME;
		}

		return $this;
	} // setName()

	/**
	 * Set the value of [surname] column.
	 * 
	 * @param      string $v new value
	 * @return     RecruitmentUser The current object (for fluent API support)
	 */
	public function setSurname($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->surname !== $v) {
			$this->surname = $v;
			$this->modifiedColumns[] = RecruitmentUserPeer::SURNAME;
		}

		return $this;
	} // setSurname()

	/**
	 * Set the value of [email] column.
	 * 
	 * @param      string $v new value
	 * @return     RecruitmentUser The current object (for fluent API support)
	 */
	public function setEmail($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->email !== $v) {
			$this->email = $v;
			$this->modifiedColumns[] = RecruitmentUserPeer::EMAIL;
		}

		return $this;
	} // setEmail()

	/**
	 * Sets the value of the [is_qualify] column.
	 * Non-boolean arguments are converted using the following rules:
	 *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
	 *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
	 * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
	 * 
	 * @param      boolean|integer|string $v The new value
	 * @return     RecruitmentUser The current object (for fluent API support)
	 */
	public function setIsQualify($v)
	{
		if ($v !== null) {
			if (is_string($v)) {
				$v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
			} else {
				$v = (boolean) $v;
			}
		}

		if ($this->is_qualify !== $v) {
			$this->is_qualify = $v;
			$this->modifiedColumns[] = RecruitmentUserPeer::IS_QUALIFY;
		}

		return $this;
	} // setIsQualify()

	/**
	 * Sets the value of the [is_active] column.
	 * Non-boolean arguments are converted using the following rules:
	 *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
	 *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
	 * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
	 * 
	 * @param      boolean|integer|string $v The new value
	 * @return     RecruitmentUser The current object (for fluent API support)
	 */
	public function setIsActive($v)
	{
		if ($v !== null) {
			if (is_string($v)) {
				$v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
			} else {
				$v = (boolean) $v;
			}
		}

		if ($this->is_active !== $v) {
			$this->is_active = $v;
			$this->modifiedColumns[] = RecruitmentUserPeer::IS_ACTIVE;
		}

		return $this;
	} // setIsActive()

	/**
	 * Sets the value of [created_at] column to a normalized version of the date/time value specified.
	 * 
	 * @param      mixed $v string, integer (timestamp), or DateTime value.
	 *               Empty strings are treated as NULL.
	 * @return     RecruitmentUser The current object (for fluent API support)
	 */
	public function setCreatedAt($v)
	{
		$dt = PropelDateTime::newInstance($v, null, 'DateTime');
		if ($this->created_at !== null || $dt !== null) {
			$currentDateAsString = ($this->created_at !== null && $tmpDt = new DateTime($this->created_at)) ? $tmpDt->format('Y-m-d H:i:s') : null;
			$newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
			if ($currentDateAsString !== $newDateAsString) {
				$this->created_at = $newDateAsString;
				$this->modifiedColumns[] = RecruitmentUserPeer::CREATED_AT;
			}
		} // if either are not null

		return $this;
	} // setCreatedAt()

	/**
	 * Sets the value of [updated_at] column to a normalized version of the date/time value specified.
	 * 
	 * @param      mixed $v string, integer (timestamp), or DateTime value.
	 *               Empty strings are treated as NULL.
	 * @return     RecruitmentUser The current object (for fluent API support)
	 */
	public function setUpdatedAt($v)
	{
		$dt = PropelDateTime::newInstance($v, null, 'DateTime');
		if ($this->updated_at !== null || $dt !== null) {
			$currentDateAsString = ($this->updated_at !== null && $tmpDt = new DateTime($this->updated_at)) ? $tmpDt->format('Y-m-d H:i:s') : null;
			$newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
			if ($currentDateAsString !== $newDateAsString) {
				$this->updated_at = $newDateAsString;
				$this->modifiedColumns[] = RecruitmentUserPeer::UPDATED_AT;
			}
		} // if either are not null

		return $this;
	} // setUpdatedAt()

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
			if ($this->is_qualify !== false) {
				return false;
			}

			if ($this->is_active !== false) {
				return false;
			}

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

			$this->id = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
			$this->recruitment_id = ($row[$startcol + 1] !== null) ? (int) $row[$startcol + 1] : null;
			$this->recruitment_date_id = ($row[$startcol + 2] !== null) ? (int) $row[$startcol + 2] : null;
			$this->name = ($row[$startcol + 3] !== null) ? (string) $row[$startcol + 3] : null;
			$this->surname = ($row[$startcol + 4] !== null) ? (string) $row[$startcol + 4] : null;
			$this->email = ($row[$startcol + 5] !== null) ? (string) $row[$startcol + 5] : null;
			$this->is_qualify = ($row[$startcol + 6] !== null) ? (boolean) $row[$startcol + 6] : null;
			$this->is_active = ($row[$startcol + 7] !== null) ? (boolean) $row[$startcol + 7] : null;
			$this->created_at = ($row[$startcol + 8] !== null) ? (string) $row[$startcol + 8] : null;
			$this->updated_at = ($row[$startcol + 9] !== null) ? (string) $row[$startcol + 9] : null;
			$this->resetModified();

			$this->setNew(false);

			if ($rehydrate) {
				$this->ensureConsistency();
			}

			return $startcol + 10; // 10 = RecruitmentUserPeer::NUM_HYDRATE_COLUMNS.

		} catch (Exception $e) {
			throw new PropelException("Error populating RecruitmentUser object", $e);
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

		if ($this->aRecruitment !== null && $this->recruitment_id !== $this->aRecruitment->getId()) {
			$this->aRecruitment = null;
		}
		if ($this->aRecruitmentDate !== null && $this->recruitment_date_id !== $this->aRecruitmentDate->getId()) {
			$this->aRecruitmentDate = null;
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
			$con = Propel::getConnection(RecruitmentUserPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		// We don't need to alter the object instance pool; we're just modifying this instance
		// already in the pool.

		$stmt = RecruitmentUserPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
		$row = $stmt->fetch(PDO::FETCH_NUM);
		$stmt->closeCursor();
		if (!$row) {
			throw new PropelException('Cannot find matching row in the database to reload object values.');
		}
		$this->hydrate($row, 0, true); // rehydrate

		if ($deep) {  // also de-associate any related objects?

			$this->aRecruitment = null;
			$this->aRecruitmentDate = null;
			$this->collRecruitmentUserDatas = null;

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
			$con = Propel::getConnection(RecruitmentUserPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}

		$con->beginTransaction();
		try {
			$deleteQuery = RecruitmentUserQuery::create()
				->filterByPrimaryKey($this->getPrimaryKey());
			$ret = $this->preDelete($con);
			if ($ret) {
				$deleteQuery->delete($con);
				$this->postDelete($con);
				$con->commit();
				$this->setDeleted(true);
			} else {
				$con->commit();
			}
		} catch (Exception $e) {
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
			$con = Propel::getConnection(RecruitmentUserPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}

		$con->beginTransaction();
		$isInsert = $this->isNew();
		try {
			$ret = $this->preSave($con);
			if ($isInsert) {
				$ret = $ret && $this->preInsert($con);
				// timestampable behavior
				if (!$this->isColumnModified(RecruitmentUserPeer::CREATED_AT)) {
					$this->setCreatedAt(time());
				}
				if (!$this->isColumnModified(RecruitmentUserPeer::UPDATED_AT)) {
					$this->setUpdatedAt(time());
				}
			} else {
				$ret = $ret && $this->preUpdate($con);
				// timestampable behavior
				if ($this->isModified() && !$this->isColumnModified(RecruitmentUserPeer::UPDATED_AT)) {
					$this->setUpdatedAt(time());
				}
			}
			if ($ret) {
				$affectedRows = $this->doSave($con);
				if ($isInsert) {
					$this->postInsert($con);
				} else {
					$this->postUpdate($con);
				}
				$this->postSave($con);
				RecruitmentUserPeer::addInstanceToPool($this);
			} else {
				$affectedRows = 0;
			}
			$con->commit();
			return $affectedRows;
		} catch (Exception $e) {
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

			if ($this->aRecruitment !== null) {
				if ($this->aRecruitment->isModified() || $this->aRecruitment->isNew()) {
					$affectedRows += $this->aRecruitment->save($con);
				}
				$this->setRecruitment($this->aRecruitment);
			}

			if ($this->aRecruitmentDate !== null) {
				if ($this->aRecruitmentDate->isModified() || $this->aRecruitmentDate->isNew()) {
					$affectedRows += $this->aRecruitmentDate->save($con);
				}
				$this->setRecruitmentDate($this->aRecruitmentDate);
			}

			if ($this->isNew() || $this->isModified()) {
				// persist changes
				if ($this->isNew()) {
					$this->doInsert($con);
				} else {
					$this->doUpdate($con);
				}
				$affectedRows += 1;
				$this->resetModified();
			}

			if ($this->recruitmentUserDatasScheduledForDeletion !== null) {
				if (!$this->recruitmentUserDatasScheduledForDeletion->isEmpty()) {
					RecruitmentUserDataQuery::create()
						->filterByPrimaryKeys($this->recruitmentUserDatasScheduledForDeletion->getPrimaryKeys(false))
						->delete($con);
					$this->recruitmentUserDatasScheduledForDeletion = null;
				}
			}

			if ($this->collRecruitmentUserDatas !== null) {
				foreach ($this->collRecruitmentUserDatas as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			$this->alreadyInSave = false;

		}
		return $affectedRows;
	} // doSave()

	/**
	 * Insert the row in the database.
	 *
	 * @param      PropelPDO $con
	 *
	 * @throws     PropelException
	 * @see        doSave()
	 */
	protected function doInsert(PropelPDO $con)
	{
		$modifiedColumns = array();
		$index = 0;

		$this->modifiedColumns[] = RecruitmentUserPeer::ID;
		if (null !== $this->id) {
			throw new PropelException('Cannot insert a value for auto-increment primary key (' . RecruitmentUserPeer::ID . ')');
		}

		 // check the columns in natural order for more readable SQL queries
		if ($this->isColumnModified(RecruitmentUserPeer::ID)) {
			$modifiedColumns[':p' . $index++]  = '`ID`';
		}
		if ($this->isColumnModified(RecruitmentUserPeer::RECRUITMENT_ID)) {
			$modifiedColumns[':p' . $index++]  = '`RECRUITMENT_ID`';
		}
		if ($this->isColumnModified(RecruitmentUserPeer::RECRUITMENT_DATE_ID)) {
			$modifiedColumns[':p' . $index++]  = '`RECRUITMENT_DATE_ID`';
		}
		if ($this->isColumnModified(RecruitmentUserPeer::NAME)) {
			$modifiedColumns[':p' . $index++]  = '`NAME`';
		}
		if ($this->isColumnModified(RecruitmentUserPeer::SURNAME)) {
			$modifiedColumns[':p' . $index++]  = '`SURNAME`';
		}
		if ($this->isColumnModified(RecruitmentUserPeer::EMAIL)) {
			$modifiedColumns[':p' . $index++]  = '`EMAIL`';
		}
		if ($this->isColumnModified(RecruitmentUserPeer::IS_QUALIFY)) {
			$modifiedColumns[':p' . $index++]  = '`IS_QUALIFY`';
		}
		if ($this->isColumnModified(RecruitmentUserPeer::IS_ACTIVE)) {
			$modifiedColumns[':p' . $index++]  = '`IS_ACTIVE`';
		}
		if ($this->isColumnModified(RecruitmentUserPeer::CREATED_AT)) {
			$modifiedColumns[':p' . $index++]  = '`CREATED_AT`';
		}
		if ($this->isColumnModified(RecruitmentUserPeer::UPDATED_AT)) {
			$modifiedColumns[':p' . $index++]  = '`UPDATED_AT`';
		}

		$sql = sprintf(
			'INSERT INTO `visual_recruitment_user` (%s) VALUES (%s)',
			implode(', ', $modifiedColumns),
			implode(', ', array_keys($modifiedColumns))
		);

		try {
			$stmt = $con->prepare($sql);
			foreach ($modifiedColumns as $identifier => $columnName) {
				switch ($columnName) {
					case '`ID`':						
						$stmt->bindValue($identifier, $this->id, PDO::PARAM_INT);
						break;
					case '`RECRUITMENT_ID`':						
						$stmt->bindValue($identifier, $this->recruitment_id, PDO::PARAM_INT);
						break;
					case '`RECRUITMENT_DATE_ID`':						
						$stmt->bindValue($identifier, $this->recruitment_date_id, PDO::PARAM_INT);
						break;
					case '`NAME`':						
						$stmt->bindValue($identifier, $this->name, PDO::PARAM_STR);
						break;
					case '`SURNAME`':						
						$stmt->bindValue($identifier, $this->surname, PDO::PARAM_STR);
						break;
					case '`EMAIL`':						
						$stmt->bindValue($identifier, $this->email, PDO::PARAM_STR);
						break;
					case '`IS_QUALIFY`':
						$stmt->bindValue($identifier, (int) $this->is_qualify, PDO::PARAM_INT);
						break;
					case '`IS_ACTIVE`':
						$stmt->bindValue($identifier, (int) $this->is_active, PDO::PARAM_INT);
						break;
					case '`CREATED_AT`':						
						$stmt->bindValue($identifier, $this->created_at, PDO::PARAM_STR);
						break;
					case '`UPDATED_AT`':						
						$stmt->bindValue($identifier, $this->updated_at, PDO::PARAM_STR);
						break;
				}
			}
			$stmt->execute();
		} catch (Exception $e) {
			Propel::log($e->getMessage(), Propel::LOG_ERR);
			throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), $e);
		}

		try {
			$pk = $con->lastInsertId();
		} catch (Exception $e) {
			throw new PropelException('Unable to get autoincrement id.', $e);
		}
		$this->setId($pk);

		$this->setNew(false);
	}

	/**
	 * Update the row in the database.
	 *
	 * @param      PropelPDO $con
	 *
	 * @see        doSave()
	 */
	protected function doUpdate(PropelPDO $con)
	{
		$selectCriteria = $this->buildPkeyCriteria();
		$valuesCriteria = $this->buildCriteria();
		BasePeer::doUpdate($selectCriteria, $valuesCriteria, $con);
	}

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

			if ($this->aRecruitment !== null) {
				if (!$this->aRecruitment->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aRecruitment->getValidationFailures());
				}
			}

			if ($this->aRecruitmentDate !== null) {
				if (!$this->aRecruitmentDate->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aRecruitmentDate->getValidationFailures());
				}
			}


			if (($retval = RecruitmentUserPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collRecruitmentUserDatas !== null) {
					foreach ($this->collRecruitmentUserDatas as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
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
		$pos = RecruitmentUserPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getId();
				break;
			case 1:
				return $this->getRecruitmentId();
				break;
			case 2:
				return $this->getRecruitmentDateId();
				break;
			case 3:
				return $this->getName();
				break;
			case 4:
				return $this->getSurname();
				break;
			case 5:
				return $this->getEmail();
				break;
			case 6:
				return $this->getIsQualify();
				break;
			case 7:
				return $this->getIsActive();
				break;
			case 8:
				return $this->getCreatedAt();
				break;
			case 9:
				return $this->getUpdatedAt();
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
	 * @param     string  $keyType (optional) One of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME,
	 *                    BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
	 *                    Defaults to BasePeer::TYPE_PHPNAME.
	 * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to TRUE.
	 * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
	 * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
	 *
	 * @return    array an associative array containing the field names (as keys) and field values
	 */
	public function toArray($keyType = BasePeer::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
	{
		if (isset($alreadyDumpedObjects['RecruitmentUser'][$this->getPrimaryKey()])) {
			return '*RECURSION*';
		}
		$alreadyDumpedObjects['RecruitmentUser'][$this->getPrimaryKey()] = true;
		$keys = RecruitmentUserPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getRecruitmentId(),
			$keys[2] => $this->getRecruitmentDateId(),
			$keys[3] => $this->getName(),
			$keys[4] => $this->getSurname(),
			$keys[5] => $this->getEmail(),
			$keys[6] => $this->getIsQualify(),
			$keys[7] => $this->getIsActive(),
			$keys[8] => $this->getCreatedAt(),
			$keys[9] => $this->getUpdatedAt(),
		);
		if ($includeForeignObjects) {
			if (null !== $this->aRecruitment) {
				$result['Recruitment'] = $this->aRecruitment->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
			}
			if (null !== $this->aRecruitmentDate) {
				$result['RecruitmentDate'] = $this->aRecruitmentDate->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
			}
			if (null !== $this->collRecruitmentUserDatas) {
				$result['RecruitmentUserDatas'] = $this->collRecruitmentUserDatas->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
			}
		}
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
		$pos = RecruitmentUserPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setId($value);
				break;
			case 1:
				$this->setRecruitmentId($value);
				break;
			case 2:
				$this->setRecruitmentDateId($value);
				break;
			case 3:
				$this->setName($value);
				break;
			case 4:
				$this->setSurname($value);
				break;
			case 5:
				$this->setEmail($value);
				break;
			case 6:
				$this->setIsQualify($value);
				break;
			case 7:
				$this->setIsActive($value);
				break;
			case 8:
				$this->setCreatedAt($value);
				break;
			case 9:
				$this->setUpdatedAt($value);
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
		$keys = RecruitmentUserPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setRecruitmentId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setRecruitmentDateId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setName($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setSurname($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setEmail($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setIsQualify($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setIsActive($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setCreatedAt($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setUpdatedAt($arr[$keys[9]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(RecruitmentUserPeer::DATABASE_NAME);

		if ($this->isColumnModified(RecruitmentUserPeer::ID)) $criteria->add(RecruitmentUserPeer::ID, $this->id);
		if ($this->isColumnModified(RecruitmentUserPeer::RECRUITMENT_ID)) $criteria->add(RecruitmentUserPeer::RECRUITMENT_ID, $this->recruitment_id);
		if ($this->isColumnModified(RecruitmentUserPeer::RECRUITMENT_DATE_ID)) $criteria->add(RecruitmentUserPeer::RECRUITMENT_DATE_ID, $this->recruitment_date_id);
		if ($this->isColumnModified(RecruitmentUserPeer::NAME)) $criteria->add(RecruitmentUserPeer::NAME, $this->name);
		if ($this->isColumnModified(RecruitmentUserPeer::SURNAME)) $criteria->add(RecruitmentUserPeer::SURNAME, $this->surname);
		if ($this->isColumnModified(RecruitmentUserPeer::EMAIL)) $criteria->add(RecruitmentUserPeer::EMAIL, $this->email);
		if ($this->isColumnModified(RecruitmentUserPeer::IS_QUALIFY)) $criteria->add(RecruitmentUserPeer::IS_QUALIFY, $this->is_qualify);
		if ($this->isColumnModified(RecruitmentUserPeer::IS_ACTIVE)) $criteria->add(RecruitmentUserPeer::IS_ACTIVE, $this->is_active);
		if ($this->isColumnModified(RecruitmentUserPeer::CREATED_AT)) $criteria->add(RecruitmentUserPeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(RecruitmentUserPeer::UPDATED_AT)) $criteria->add(RecruitmentUserPeer::UPDATED_AT, $this->updated_at);

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
		$criteria = new Criteria(RecruitmentUserPeer::DATABASE_NAME);
		$criteria->add(RecruitmentUserPeer::ID, $this->id);

		return $criteria;
	}

	/**
	 * Returns the primary key for this object (row).
	 * @return     int
	 */
	public function getPrimaryKey()
	{
		return $this->getId();
	}

	/**
	 * Generic method to set the primary key (id column).
	 *
	 * @param      int $key Primary key.
	 * @return     void
	 */
	public function setPrimaryKey($key)
	{
		$this->setId($key);
	}

	/**
	 * Returns true if the primary key for this object is null.
	 * @return     boolean
	 */
	public function isPrimaryKeyNull()
	{
		return null === $this->getId();
	}

	/**
	 * Sets contents of passed object to values from current object.
	 *
	 * If desired, this method can also make copies of all associated (fkey referrers)
	 * objects.
	 *
	 * @param      object $copyObj An object of RecruitmentUser (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
	{
		$copyObj->setRecruitmentId($this->getRecruitmentId());
		$copyObj->setRecruitmentDateId($this->getRecruitmentDateId());
		$copyObj->setName($this->getName());
		$copyObj->setSurname($this->getSurname());
		$copyObj->setEmail($this->getEmail());
		$copyObj->setIsQualify($this->getIsQualify());
		$copyObj->setIsActive($this->getIsActive());
		$copyObj->setCreatedAt($this->getCreatedAt());
		$copyObj->setUpdatedAt($this->getUpdatedAt());

		if ($deepCopy && !$this->startCopy) {
			// important: temporarily setNew(false) because this affects the behavior of
			// the getter/setter methods for fkey referrer objects.
			$copyObj->setNew(false);
			// store object hash to prevent cycle
			$this->startCopy = true;

			foreach ($this->getRecruitmentUserDatas() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addRecruitmentUserData($relObj->copy($deepCopy));
				}
			}

			//unflag object copy
			$this->startCopy = false;
		} // if ($deepCopy)

		if ($makeNew) {
			$copyObj->setNew(true);
			$copyObj->setId(NULL); // this is a auto-increment column, so set to default value
		}
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
	 * @return     RecruitmentUser Clone of current object.
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
	 * @return     RecruitmentUserPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new RecruitmentUserPeer();
		}
		return self::$peer;
	}

	/**
	 * Declares an association between this object and a Recruitment object.
	 *
	 * @param      Recruitment $v
	 * @return     RecruitmentUser The current object (for fluent API support)
	 * @throws     PropelException
	 */
	public function setRecruitment(Recruitment $v = null)
	{
		if ($v === null) {
			$this->setRecruitmentId(NULL);
		} else {
			$this->setRecruitmentId($v->getId());
		}

		$this->aRecruitment = $v;

		// Add binding for other direction of this n:n relationship.
		// If this object has already been added to the Recruitment object, it will not be re-added.
		if ($v !== null) {
			$v->addRecruitmentUser($this);
		}

		return $this;
	}


	/**
	 * Get the associated Recruitment object
	 *
	 * @param      PropelPDO Optional Connection object.
	 * @return     Recruitment The associated Recruitment object.
	 * @throws     PropelException
	 */
	public function getRecruitment(PropelPDO $con = null)
	{
		if ($this->aRecruitment === null && ($this->recruitment_id !== null)) {
			$this->aRecruitment = RecruitmentQuery::create()->findPk($this->recruitment_id, $con);
			/* The following can be used additionally to
				guarantee the related object contains a reference
				to this object.  This level of coupling may, however, be
				undesirable since it could result in an only partially populated collection
				in the referenced object.
				$this->aRecruitment->addRecruitmentUsers($this);
			 */
		}
		return $this->aRecruitment;
	}

	/**
	 * Declares an association between this object and a RecruitmentDate object.
	 *
	 * @param      RecruitmentDate $v
	 * @return     RecruitmentUser The current object (for fluent API support)
	 * @throws     PropelException
	 */
	public function setRecruitmentDate(RecruitmentDate $v = null)
	{
		if ($v === null) {
			$this->setRecruitmentDateId(NULL);
		} else {
			$this->setRecruitmentDateId($v->getId());
		}

		$this->aRecruitmentDate = $v;

		// Add binding for other direction of this n:n relationship.
		// If this object has already been added to the RecruitmentDate object, it will not be re-added.
		if ($v !== null) {
			$v->addRecruitmentUser($this);
		}

		return $this;
	}


	/**
	 * Get the associated RecruitmentDate object
	 *
	 * @param      PropelPDO Optional Connection object.
	 * @return     RecruitmentDate The associated RecruitmentDate object.
	 * @throws     PropelException
	 */
	public function getRecruitmentDate(PropelPDO $con = null)
	{
		if ($this->aRecruitmentDate === null && ($this->recruitment_date_id !== null)) {
			$this->aRecruitmentDate = RecruitmentDateQuery::create()->findPk($this->recruitment_date_id, $con);
			/* The following can be used additionally to
				guarantee the related object contains a reference
				to this object.  This level of coupling may, however, be
				undesirable since it could result in an only partially populated collection
				in the referenced object.
				$this->aRecruitmentDate->addRecruitmentUsers($this);
			 */
		}
		return $this->aRecruitmentDate;
	}


	/**
	 * Initializes a collection based on the name of a relation.
	 * Avoids crafting an 'init[$relationName]s' method name
	 * that wouldn't work when StandardEnglishPluralizer is used.
	 *
	 * @param      string $relationName The name of the relation to initialize
	 * @return     void
	 */
	public function initRelation($relationName)
	{
		if ('RecruitmentUserData' == $relationName) {
			return $this->initRecruitmentUserDatas();
		}
	}

	/**
	 * Clears out the collRecruitmentUserDatas collection
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addRecruitmentUserDatas()
	 */
	public function clearRecruitmentUserDatas()
	{
		$this->collRecruitmentUserDatas = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collRecruitmentUserDatas collection.
	 *
	 * By default this just sets the collRecruitmentUserDatas collection to an empty array (like clearcollRecruitmentUserDatas());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @param      boolean $overrideExisting If set to true, the method call initializes
	 *                                        the collection even if it is not empty
	 *
	 * @return     void
	 */
	public function initRecruitmentUserDatas($overrideExisting = true)
	{
		if (null !== $this->collRecruitmentUserDatas && !$overrideExisting) {
			return;
		}
		$this->collRecruitmentUserDatas = new PropelObjectCollection();
		$this->collRecruitmentUserDatas->setModel('RecruitmentUserData');
	}

	/**
	 * Gets an array of RecruitmentUserData objects which contain a foreign key that references this object.
	 *
	 * If the $criteria is not null, it is used to always fetch the results from the database.
	 * Otherwise the results are fetched from the database the first time, then cached.
	 * Next time the same method is called without $criteria, the cached collection is returned.
	 * If this RecruitmentUser is new, it will return
	 * an empty collection or the current collection; the criteria is ignored on a new object.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @return     PropelCollection|array RecruitmentUserData[] List of RecruitmentUserData objects
	 * @throws     PropelException
	 */
	public function getRecruitmentUserDatas($criteria = null, PropelPDO $con = null)
	{
		if(null === $this->collRecruitmentUserDatas || null !== $criteria) {
			if ($this->isNew() && null === $this->collRecruitmentUserDatas) {
				// return empty collection
				$this->initRecruitmentUserDatas();
			} else {
				$collRecruitmentUserDatas = RecruitmentUserDataQuery::create(null, $criteria)
					->filterByRecruitmentUser($this)
					->find($con);
				if (null !== $criteria) {
					return $collRecruitmentUserDatas;
				}
				$this->collRecruitmentUserDatas = $collRecruitmentUserDatas;
			}
		}
		return $this->collRecruitmentUserDatas;
	}

	/**
	 * Sets a collection of RecruitmentUserData objects related by a one-to-many relationship
	 * to the current object.
	 * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
	 * and new objects from the given Propel collection.
	 *
	 * @param      PropelCollection $recruitmentUserDatas A Propel collection.
	 * @param      PropelPDO $con Optional connection object
	 */
	public function setRecruitmentUserDatas(PropelCollection $recruitmentUserDatas, PropelPDO $con = null)
	{
		$this->recruitmentUserDatasScheduledForDeletion = $this->getRecruitmentUserDatas(new Criteria(), $con)->diff($recruitmentUserDatas);

		foreach ($recruitmentUserDatas as $recruitmentUserData) {
			// Fix issue with collection modified by reference
			if ($recruitmentUserData->isNew()) {
				$recruitmentUserData->setRecruitmentUser($this);
			}
			$this->addRecruitmentUserData($recruitmentUserData);
		}

		$this->collRecruitmentUserDatas = $recruitmentUserDatas;
	}

	/**
	 * Returns the number of related RecruitmentUserData objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related RecruitmentUserData objects.
	 * @throws     PropelException
	 */
	public function countRecruitmentUserDatas(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if(null === $this->collRecruitmentUserDatas || null !== $criteria) {
			if ($this->isNew() && null === $this->collRecruitmentUserDatas) {
				return 0;
			} else {
				$query = RecruitmentUserDataQuery::create(null, $criteria);
				if($distinct) {
					$query->distinct();
				}
				return $query
					->filterByRecruitmentUser($this)
					->count($con);
			}
		} else {
			return count($this->collRecruitmentUserDatas);
		}
	}

	/**
	 * Method called to associate a RecruitmentUserData object to this object
	 * through the RecruitmentUserData foreign key attribute.
	 *
	 * @param      RecruitmentUserData $l RecruitmentUserData
	 * @return     RecruitmentUser The current object (for fluent API support)
	 */
	public function addRecruitmentUserData(RecruitmentUserData $l)
	{
		if ($this->collRecruitmentUserDatas === null) {
			$this->initRecruitmentUserDatas();
		}
		if (!$this->collRecruitmentUserDatas->contains($l)) { // only add it if the **same** object is not already associated
			$this->doAddRecruitmentUserData($l);
		}

		return $this;
	}

	/**
	 * @param	RecruitmentUserData $recruitmentUserData The recruitmentUserData object to add.
	 */
	protected function doAddRecruitmentUserData($recruitmentUserData)
	{
		$this->collRecruitmentUserDatas[]= $recruitmentUserData;
		$recruitmentUserData->setRecruitmentUser($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this RecruitmentUser is new, it will return
	 * an empty collection; or if this RecruitmentUser has previously
	 * been saved, it will retrieve related RecruitmentUserDatas from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in RecruitmentUser.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @param      string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
	 * @return     PropelCollection|array RecruitmentUserData[] List of RecruitmentUserData objects
	 */
	public function getRecruitmentUserDatasJoinQuestion($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$query = RecruitmentUserDataQuery::create(null, $criteria);
		$query->joinWith('Question', $join_behavior);

		return $this->getRecruitmentUserDatas($query, $con);
	}

	/**
	 * Clears the current object and sets all attributes to their default values
	 */
	public function clear()
	{
		$this->id = null;
		$this->recruitment_id = null;
		$this->recruitment_date_id = null;
		$this->name = null;
		$this->surname = null;
		$this->email = null;
		$this->is_qualify = null;
		$this->is_active = null;
		$this->created_at = null;
		$this->updated_at = null;
		$this->alreadyInSave = false;
		$this->alreadyInValidation = false;
		$this->clearAllReferences();
		$this->applyDefaultValues();
		$this->resetModified();
		$this->setNew(true);
		$this->setDeleted(false);
	}

	/**
	 * Resets all references to other model objects or collections of model objects.
	 *
	 * This method is a user-space workaround for PHP's inability to garbage collect
	 * objects with circular references (even in PHP 5.3). This is currently necessary
	 * when using Propel in certain daemon or large-volumne/high-memory operations.
	 *
	 * @param      boolean $deep Whether to also clear the references on all referrer objects.
	 */
	public function clearAllReferences($deep = false)
	{
		if ($deep) {
			if ($this->collRecruitmentUserDatas) {
				foreach ($this->collRecruitmentUserDatas as $o) {
					$o->clearAllReferences($deep);
				}
			}
		} // if ($deep)

		if ($this->collRecruitmentUserDatas instanceof PropelCollection) {
			$this->collRecruitmentUserDatas->clearIterator();
		}
		$this->collRecruitmentUserDatas = null;
		$this->aRecruitment = null;
		$this->aRecruitmentDate = null;
	}

	/**
	 * Return the string representation of this object
	 *
	 * @return string
	 */
	public function __toString()
	{
		return (string) $this->exportTo(RecruitmentUserPeer::DEFAULT_STRING_FORMAT);
	}

	// timestampable behavior
	
	/**
	 * Mark the current object so that the update date doesn't get updated during next save
	 *
	 * @return     RecruitmentUser The current object (for fluent API support)
	 */
	public function keepUpdateDateUnchanged()
	{
		$this->modifiedColumns[] = RecruitmentUserPeer::UPDATED_AT;
		return $this;
	}

} // BaseRecruitmentUser
