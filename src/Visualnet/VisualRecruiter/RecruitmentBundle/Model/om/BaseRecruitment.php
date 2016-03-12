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
use Visualnet\UserBundle\Model\Group;
use Visualnet\UserBundle\Model\GroupQuery;
use Visualnet\UserBundle\Model\User;
use Visualnet\UserBundle\Model\UserQuery;
use Visualnet\VisualRecruiter\FormBundle\Model\Form;
use Visualnet\VisualRecruiter\FormBundle\Model\FormQuery;
use Visualnet\VisualRecruiter\RecruitmentBundle\Model\RecruitmentDate;
use Visualnet\VisualRecruiter\RecruitmentBundle\Model\RecruitmentDateQuery;
use Visualnet\VisualRecruiter\RecruitmentBundle\Model\RecruitmentPeer;
use Visualnet\VisualRecruiter\RecruitmentBundle\Model\RecruitmentQuery;
use Visualnet\VisualRecruiter\RecruitmentBundle\Model\RecruitmentUser;
use Visualnet\VisualRecruiter\RecruitmentBundle\Model\RecruitmentUserQuery;

/**
 * Base class that represents a row from the 'visual_recruitment' table.
 *
 * 
 *
 * @package    propel.generator.src.Visualnet.VisualRecruiter.RecruitmentBundle.Model.om
 */
abstract class BaseRecruitment extends BaseObject  implements Persistent
{

	/**
	 * Peer class name
	 */
	const PEER = 'Visualnet\\VisualRecruiter\\RecruitmentBundle\\Model\\RecruitmentPeer';

	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        RecruitmentPeer
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
	 * The value for the form_id field.
	 * @var        int
	 */
	protected $form_id;

	/**
	 * The value for the user_id field.
	 * @var        int
	 */
	protected $user_id;

	/**
	 * The value for the group_id field.
	 * @var        int
	 */
	protected $group_id;

	/**
	 * The value for the name field.
	 * @var        string
	 */
	protected $name;

	/**
	 * The value for the alias_name field.
	 * @var        string
	 */
	protected $alias_name;

	/**
	 * The value for the place field.
	 * @var        string
	 */
	protected $place;

	/**
	 * The value for the is_active field.
	 * Note: this column has a database default value of: false
	 * @var        boolean
	 */
	protected $is_active;

	/**
	 * The value for the description field.
	 * @var        string
	 */
	protected $description;

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
	 * @var        Form
	 */
	protected $aForm;

	/**
	 * @var        User
	 */
	protected $aUser;

	/**
	 * @var        Group
	 */
	protected $aGroup;

	/**
	 * @var        array RecruitmentDate[] Collection to store aggregation of RecruitmentDate objects.
	 */
	protected $collRecruitmentDates;

	/**
	 * @var        array RecruitmentUser[] Collection to store aggregation of RecruitmentUser objects.
	 */
	protected $collRecruitmentUsers;

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
	protected $recruitmentDatesScheduledForDeletion = null;

	/**
	 * An array of objects scheduled for deletion.
	 * @var		array
	 */
	protected $recruitmentUsersScheduledForDeletion = null;

	/**
	 * Applies default values to this object.
	 * This method should be called from the object's constructor (or
	 * equivalent initialization method).
	 * @see        __construct()
	 */
	public function applyDefaultValues()
	{
		$this->is_active = false;
	}

	/**
	 * Initializes internal state of BaseRecruitment object.
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
	 * Get the [form_id] column value.
	 * 
	 * @return     int
	 */
	public function getFormId()
	{
		return $this->form_id;
	}

	/**
	 * Get the [user_id] column value.
	 * 
	 * @return     int
	 */
	public function getUserId()
	{
		return $this->user_id;
	}

	/**
	 * Get the [group_id] column value.
	 * 
	 * @return     int
	 */
	public function getGroupId()
	{
		return $this->group_id;
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
	 * Get the [alias_name] column value.
	 * 
	 * @return     string
	 */
	public function getAliasName()
	{
		return $this->alias_name;
	}

	/**
	 * Get the [place] column value.
	 * 
	 * @return     string
	 */
	public function getPlace()
	{
		return $this->place;
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
	 * Get the [description] column value.
	 * 
	 * @return     string
	 */
	public function getDescription()
	{
		return $this->description;
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
	 * @return     Recruitment The current object (for fluent API support)
	 */
	public function setId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = RecruitmentPeer::ID;
		}

		return $this;
	} // setId()

	/**
	 * Set the value of [form_id] column.
	 * 
	 * @param      int $v new value
	 * @return     Recruitment The current object (for fluent API support)
	 */
	public function setFormId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->form_id !== $v) {
			$this->form_id = $v;
			$this->modifiedColumns[] = RecruitmentPeer::FORM_ID;
		}

		if ($this->aForm !== null && $this->aForm->getId() !== $v) {
			$this->aForm = null;
		}

		return $this;
	} // setFormId()

	/**
	 * Set the value of [user_id] column.
	 * 
	 * @param      int $v new value
	 * @return     Recruitment The current object (for fluent API support)
	 */
	public function setUserId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->user_id !== $v) {
			$this->user_id = $v;
			$this->modifiedColumns[] = RecruitmentPeer::USER_ID;
		}

		if ($this->aUser !== null && $this->aUser->getId() !== $v) {
			$this->aUser = null;
		}

		return $this;
	} // setUserId()

	/**
	 * Set the value of [group_id] column.
	 * 
	 * @param      int $v new value
	 * @return     Recruitment The current object (for fluent API support)
	 */
	public function setGroupId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->group_id !== $v) {
			$this->group_id = $v;
			$this->modifiedColumns[] = RecruitmentPeer::GROUP_ID;
		}

		if ($this->aGroup !== null && $this->aGroup->getId() !== $v) {
			$this->aGroup = null;
		}

		return $this;
	} // setGroupId()

	/**
	 * Set the value of [name] column.
	 * 
	 * @param      string $v new value
	 * @return     Recruitment The current object (for fluent API support)
	 */
	public function setName($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->name !== $v) {
			$this->name = $v;
			$this->modifiedColumns[] = RecruitmentPeer::NAME;
		}

		return $this;
	} // setName()

	/**
	 * Set the value of [alias_name] column.
	 * 
	 * @param      string $v new value
	 * @return     Recruitment The current object (for fluent API support)
	 */
	public function setAliasName($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->alias_name !== $v) {
			$this->alias_name = $v;
			$this->modifiedColumns[] = RecruitmentPeer::ALIAS_NAME;
		}

		return $this;
	} // setAliasName()

	/**
	 * Set the value of [place] column.
	 * 
	 * @param      string $v new value
	 * @return     Recruitment The current object (for fluent API support)
	 */
	public function setPlace($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->place !== $v) {
			$this->place = $v;
			$this->modifiedColumns[] = RecruitmentPeer::PLACE;
		}

		return $this;
	} // setPlace()

	/**
	 * Sets the value of the [is_active] column.
	 * Non-boolean arguments are converted using the following rules:
	 *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
	 *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
	 * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
	 * 
	 * @param      boolean|integer|string $v The new value
	 * @return     Recruitment The current object (for fluent API support)
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
			$this->modifiedColumns[] = RecruitmentPeer::IS_ACTIVE;
		}

		return $this;
	} // setIsActive()

	/**
	 * Set the value of [description] column.
	 * 
	 * @param      string $v new value
	 * @return     Recruitment The current object (for fluent API support)
	 */
	public function setDescription($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->description !== $v) {
			$this->description = $v;
			$this->modifiedColumns[] = RecruitmentPeer::DESCRIPTION;
		}

		return $this;
	} // setDescription()

	/**
	 * Sets the value of [created_at] column to a normalized version of the date/time value specified.
	 * 
	 * @param      mixed $v string, integer (timestamp), or DateTime value.
	 *               Empty strings are treated as NULL.
	 * @return     Recruitment The current object (for fluent API support)
	 */
	public function setCreatedAt($v)
	{
		$dt = PropelDateTime::newInstance($v, null, 'DateTime');
		if ($this->created_at !== null || $dt !== null) {
			$currentDateAsString = ($this->created_at !== null && $tmpDt = new DateTime($this->created_at)) ? $tmpDt->format('Y-m-d H:i:s') : null;
			$newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
			if ($currentDateAsString !== $newDateAsString) {
				$this->created_at = $newDateAsString;
				$this->modifiedColumns[] = RecruitmentPeer::CREATED_AT;
			}
		} // if either are not null

		return $this;
	} // setCreatedAt()

	/**
	 * Sets the value of [updated_at] column to a normalized version of the date/time value specified.
	 * 
	 * @param      mixed $v string, integer (timestamp), or DateTime value.
	 *               Empty strings are treated as NULL.
	 * @return     Recruitment The current object (for fluent API support)
	 */
	public function setUpdatedAt($v)
	{
		$dt = PropelDateTime::newInstance($v, null, 'DateTime');
		if ($this->updated_at !== null || $dt !== null) {
			$currentDateAsString = ($this->updated_at !== null && $tmpDt = new DateTime($this->updated_at)) ? $tmpDt->format('Y-m-d H:i:s') : null;
			$newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
			if ($currentDateAsString !== $newDateAsString) {
				$this->updated_at = $newDateAsString;
				$this->modifiedColumns[] = RecruitmentPeer::UPDATED_AT;
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
			$this->form_id = ($row[$startcol + 1] !== null) ? (int) $row[$startcol + 1] : null;
			$this->user_id = ($row[$startcol + 2] !== null) ? (int) $row[$startcol + 2] : null;
			$this->group_id = ($row[$startcol + 3] !== null) ? (int) $row[$startcol + 3] : null;
			$this->name = ($row[$startcol + 4] !== null) ? (string) $row[$startcol + 4] : null;
			$this->alias_name = ($row[$startcol + 5] !== null) ? (string) $row[$startcol + 5] : null;
			$this->place = ($row[$startcol + 6] !== null) ? (string) $row[$startcol + 6] : null;
			$this->is_active = ($row[$startcol + 7] !== null) ? (boolean) $row[$startcol + 7] : null;
			$this->description = ($row[$startcol + 8] !== null) ? (string) $row[$startcol + 8] : null;
			$this->created_at = ($row[$startcol + 9] !== null) ? (string) $row[$startcol + 9] : null;
			$this->updated_at = ($row[$startcol + 10] !== null) ? (string) $row[$startcol + 10] : null;
			$this->resetModified();

			$this->setNew(false);

			if ($rehydrate) {
				$this->ensureConsistency();
			}

			return $startcol + 11; // 11 = RecruitmentPeer::NUM_HYDRATE_COLUMNS.

		} catch (Exception $e) {
			throw new PropelException("Error populating Recruitment object", $e);
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

		if ($this->aForm !== null && $this->form_id !== $this->aForm->getId()) {
			$this->aForm = null;
		}
		if ($this->aUser !== null && $this->user_id !== $this->aUser->getId()) {
			$this->aUser = null;
		}
		if ($this->aGroup !== null && $this->group_id !== $this->aGroup->getId()) {
			$this->aGroup = null;
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
			$con = Propel::getConnection(RecruitmentPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		// We don't need to alter the object instance pool; we're just modifying this instance
		// already in the pool.

		$stmt = RecruitmentPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
		$row = $stmt->fetch(PDO::FETCH_NUM);
		$stmt->closeCursor();
		if (!$row) {
			throw new PropelException('Cannot find matching row in the database to reload object values.');
		}
		$this->hydrate($row, 0, true); // rehydrate

		if ($deep) {  // also de-associate any related objects?

			$this->aForm = null;
			$this->aUser = null;
			$this->aGroup = null;
			$this->collRecruitmentDates = null;

			$this->collRecruitmentUsers = null;

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
			$con = Propel::getConnection(RecruitmentPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}

		$con->beginTransaction();
		try {
			$deleteQuery = RecruitmentQuery::create()
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
			$con = Propel::getConnection(RecruitmentPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}

		$con->beginTransaction();
		$isInsert = $this->isNew();
		try {
			$ret = $this->preSave($con);
			if ($isInsert) {
				$ret = $ret && $this->preInsert($con);
				// timestampable behavior
				if (!$this->isColumnModified(RecruitmentPeer::CREATED_AT)) {
					$this->setCreatedAt(time());
				}
				if (!$this->isColumnModified(RecruitmentPeer::UPDATED_AT)) {
					$this->setUpdatedAt(time());
				}
			} else {
				$ret = $ret && $this->preUpdate($con);
				// timestampable behavior
				if ($this->isModified() && !$this->isColumnModified(RecruitmentPeer::UPDATED_AT)) {
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
				RecruitmentPeer::addInstanceToPool($this);
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

			if ($this->aForm !== null) {
				if ($this->aForm->isModified() || $this->aForm->isNew()) {
					$affectedRows += $this->aForm->save($con);
				}
				$this->setForm($this->aForm);
			}

			if ($this->aUser !== null) {
				if ($this->aUser->isModified() || $this->aUser->isNew()) {
					$affectedRows += $this->aUser->save($con);
				}
				$this->setUser($this->aUser);
			}

			if ($this->aGroup !== null) {
				if ($this->aGroup->isModified() || $this->aGroup->isNew()) {
					$affectedRows += $this->aGroup->save($con);
				}
				$this->setGroup($this->aGroup);
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

			if ($this->recruitmentDatesScheduledForDeletion !== null) {
				if (!$this->recruitmentDatesScheduledForDeletion->isEmpty()) {
					RecruitmentDateQuery::create()
						->filterByPrimaryKeys($this->recruitmentDatesScheduledForDeletion->getPrimaryKeys(false))
						->delete($con);
					$this->recruitmentDatesScheduledForDeletion = null;
				}
			}

			if ($this->collRecruitmentDates !== null) {
				foreach ($this->collRecruitmentDates as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->recruitmentUsersScheduledForDeletion !== null) {
				if (!$this->recruitmentUsersScheduledForDeletion->isEmpty()) {
					RecruitmentUserQuery::create()
						->filterByPrimaryKeys($this->recruitmentUsersScheduledForDeletion->getPrimaryKeys(false))
						->delete($con);
					$this->recruitmentUsersScheduledForDeletion = null;
				}
			}

			if ($this->collRecruitmentUsers !== null) {
				foreach ($this->collRecruitmentUsers as $referrerFK) {
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

		$this->modifiedColumns[] = RecruitmentPeer::ID;
		if (null !== $this->id) {
			throw new PropelException('Cannot insert a value for auto-increment primary key (' . RecruitmentPeer::ID . ')');
		}

		 // check the columns in natural order for more readable SQL queries
		if ($this->isColumnModified(RecruitmentPeer::ID)) {
			$modifiedColumns[':p' . $index++]  = '`ID`';
		}
		if ($this->isColumnModified(RecruitmentPeer::FORM_ID)) {
			$modifiedColumns[':p' . $index++]  = '`FORM_ID`';
		}
		if ($this->isColumnModified(RecruitmentPeer::USER_ID)) {
			$modifiedColumns[':p' . $index++]  = '`USER_ID`';
		}
		if ($this->isColumnModified(RecruitmentPeer::GROUP_ID)) {
			$modifiedColumns[':p' . $index++]  = '`GROUP_ID`';
		}
		if ($this->isColumnModified(RecruitmentPeer::NAME)) {
			$modifiedColumns[':p' . $index++]  = '`NAME`';
		}
		if ($this->isColumnModified(RecruitmentPeer::ALIAS_NAME)) {
			$modifiedColumns[':p' . $index++]  = '`ALIAS_NAME`';
		}
		if ($this->isColumnModified(RecruitmentPeer::PLACE)) {
			$modifiedColumns[':p' . $index++]  = '`PLACE`';
		}
		if ($this->isColumnModified(RecruitmentPeer::IS_ACTIVE)) {
			$modifiedColumns[':p' . $index++]  = '`IS_ACTIVE`';
		}
		if ($this->isColumnModified(RecruitmentPeer::DESCRIPTION)) {
			$modifiedColumns[':p' . $index++]  = '`DESCRIPTION`';
		}
		if ($this->isColumnModified(RecruitmentPeer::CREATED_AT)) {
			$modifiedColumns[':p' . $index++]  = '`CREATED_AT`';
		}
		if ($this->isColumnModified(RecruitmentPeer::UPDATED_AT)) {
			$modifiedColumns[':p' . $index++]  = '`UPDATED_AT`';
		}

		$sql = sprintf(
			'INSERT INTO `visual_recruitment` (%s) VALUES (%s)',
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
					case '`FORM_ID`':						
						$stmt->bindValue($identifier, $this->form_id, PDO::PARAM_INT);
						break;
					case '`USER_ID`':						
						$stmt->bindValue($identifier, $this->user_id, PDO::PARAM_INT);
						break;
					case '`GROUP_ID`':						
						$stmt->bindValue($identifier, $this->group_id, PDO::PARAM_INT);
						break;
					case '`NAME`':						
						$stmt->bindValue($identifier, $this->name, PDO::PARAM_STR);
						break;
					case '`ALIAS_NAME`':						
						$stmt->bindValue($identifier, $this->alias_name, PDO::PARAM_STR);
						break;
					case '`PLACE`':						
						$stmt->bindValue($identifier, $this->place, PDO::PARAM_STR);
						break;
					case '`IS_ACTIVE`':
						$stmt->bindValue($identifier, (int) $this->is_active, PDO::PARAM_INT);
						break;
					case '`DESCRIPTION`':						
						$stmt->bindValue($identifier, $this->description, PDO::PARAM_STR);
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

			if ($this->aForm !== null) {
				if (!$this->aForm->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aForm->getValidationFailures());
				}
			}

			if ($this->aUser !== null) {
				if (!$this->aUser->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aUser->getValidationFailures());
				}
			}

			if ($this->aGroup !== null) {
				if (!$this->aGroup->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aGroup->getValidationFailures());
				}
			}


			if (($retval = RecruitmentPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collRecruitmentDates !== null) {
					foreach ($this->collRecruitmentDates as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collRecruitmentUsers !== null) {
					foreach ($this->collRecruitmentUsers as $referrerFK) {
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
		$pos = RecruitmentPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getFormId();
				break;
			case 2:
				return $this->getUserId();
				break;
			case 3:
				return $this->getGroupId();
				break;
			case 4:
				return $this->getName();
				break;
			case 5:
				return $this->getAliasName();
				break;
			case 6:
				return $this->getPlace();
				break;
			case 7:
				return $this->getIsActive();
				break;
			case 8:
				return $this->getDescription();
				break;
			case 9:
				return $this->getCreatedAt();
				break;
			case 10:
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
		if (isset($alreadyDumpedObjects['Recruitment'][$this->getPrimaryKey()])) {
			return '*RECURSION*';
		}
		$alreadyDumpedObjects['Recruitment'][$this->getPrimaryKey()] = true;
		$keys = RecruitmentPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getFormId(),
			$keys[2] => $this->getUserId(),
			$keys[3] => $this->getGroupId(),
			$keys[4] => $this->getName(),
			$keys[5] => $this->getAliasName(),
			$keys[6] => $this->getPlace(),
			$keys[7] => $this->getIsActive(),
			$keys[8] => $this->getDescription(),
			$keys[9] => $this->getCreatedAt(),
			$keys[10] => $this->getUpdatedAt(),
		);
		if ($includeForeignObjects) {
			if (null !== $this->aForm) {
				$result['Form'] = $this->aForm->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
			}
			if (null !== $this->aUser) {
				$result['User'] = $this->aUser->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
			}
			if (null !== $this->aGroup) {
				$result['Group'] = $this->aGroup->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
			}
			if (null !== $this->collRecruitmentDates) {
				$result['RecruitmentDates'] = $this->collRecruitmentDates->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
			}
			if (null !== $this->collRecruitmentUsers) {
				$result['RecruitmentUsers'] = $this->collRecruitmentUsers->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
		$pos = RecruitmentPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setFormId($value);
				break;
			case 2:
				$this->setUserId($value);
				break;
			case 3:
				$this->setGroupId($value);
				break;
			case 4:
				$this->setName($value);
				break;
			case 5:
				$this->setAliasName($value);
				break;
			case 6:
				$this->setPlace($value);
				break;
			case 7:
				$this->setIsActive($value);
				break;
			case 8:
				$this->setDescription($value);
				break;
			case 9:
				$this->setCreatedAt($value);
				break;
			case 10:
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
		$keys = RecruitmentPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setFormId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setUserId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setGroupId($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setName($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setAliasName($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setPlace($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setIsActive($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setDescription($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setCreatedAt($arr[$keys[9]]);
		if (array_key_exists($keys[10], $arr)) $this->setUpdatedAt($arr[$keys[10]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(RecruitmentPeer::DATABASE_NAME);

		if ($this->isColumnModified(RecruitmentPeer::ID)) $criteria->add(RecruitmentPeer::ID, $this->id);
		if ($this->isColumnModified(RecruitmentPeer::FORM_ID)) $criteria->add(RecruitmentPeer::FORM_ID, $this->form_id);
		if ($this->isColumnModified(RecruitmentPeer::USER_ID)) $criteria->add(RecruitmentPeer::USER_ID, $this->user_id);
		if ($this->isColumnModified(RecruitmentPeer::GROUP_ID)) $criteria->add(RecruitmentPeer::GROUP_ID, $this->group_id);
		if ($this->isColumnModified(RecruitmentPeer::NAME)) $criteria->add(RecruitmentPeer::NAME, $this->name);
		if ($this->isColumnModified(RecruitmentPeer::ALIAS_NAME)) $criteria->add(RecruitmentPeer::ALIAS_NAME, $this->alias_name);
		if ($this->isColumnModified(RecruitmentPeer::PLACE)) $criteria->add(RecruitmentPeer::PLACE, $this->place);
		if ($this->isColumnModified(RecruitmentPeer::IS_ACTIVE)) $criteria->add(RecruitmentPeer::IS_ACTIVE, $this->is_active);
		if ($this->isColumnModified(RecruitmentPeer::DESCRIPTION)) $criteria->add(RecruitmentPeer::DESCRIPTION, $this->description);
		if ($this->isColumnModified(RecruitmentPeer::CREATED_AT)) $criteria->add(RecruitmentPeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(RecruitmentPeer::UPDATED_AT)) $criteria->add(RecruitmentPeer::UPDATED_AT, $this->updated_at);

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
		$criteria = new Criteria(RecruitmentPeer::DATABASE_NAME);
		$criteria->add(RecruitmentPeer::ID, $this->id);

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
	 * @param      object $copyObj An object of Recruitment (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
	{
		$copyObj->setFormId($this->getFormId());
		$copyObj->setUserId($this->getUserId());
		$copyObj->setGroupId($this->getGroupId());
		$copyObj->setName($this->getName());
		$copyObj->setAliasName($this->getAliasName());
		$copyObj->setPlace($this->getPlace());
		$copyObj->setIsActive($this->getIsActive());
		$copyObj->setDescription($this->getDescription());
		$copyObj->setCreatedAt($this->getCreatedAt());
		$copyObj->setUpdatedAt($this->getUpdatedAt());

		if ($deepCopy && !$this->startCopy) {
			// important: temporarily setNew(false) because this affects the behavior of
			// the getter/setter methods for fkey referrer objects.
			$copyObj->setNew(false);
			// store object hash to prevent cycle
			$this->startCopy = true;

			foreach ($this->getRecruitmentDates() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addRecruitmentDate($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getRecruitmentUsers() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addRecruitmentUser($relObj->copy($deepCopy));
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
	 * @return     Recruitment Clone of current object.
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
	 * @return     RecruitmentPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new RecruitmentPeer();
		}
		return self::$peer;
	}

	/**
	 * Declares an association between this object and a Form object.
	 *
	 * @param      Form $v
	 * @return     Recruitment The current object (for fluent API support)
	 * @throws     PropelException
	 */
	public function setForm(Form $v = null)
	{
		if ($v === null) {
			$this->setFormId(NULL);
		} else {
			$this->setFormId($v->getId());
		}

		$this->aForm = $v;

		// Add binding for other direction of this n:n relationship.
		// If this object has already been added to the Form object, it will not be re-added.
		if ($v !== null) {
			$v->addRecruitment($this);
		}

		return $this;
	}


	/**
	 * Get the associated Form object
	 *
	 * @param      PropelPDO Optional Connection object.
	 * @return     Form The associated Form object.
	 * @throws     PropelException
	 */
	public function getForm(PropelPDO $con = null)
	{
		if ($this->aForm === null && ($this->form_id !== null)) {
			$this->aForm = FormQuery::create()
				->filterByRecruitment($this) // here
				->findOne($con);
			/* The following can be used additionally to
				guarantee the related object contains a reference
				to this object.  This level of coupling may, however, be
				undesirable since it could result in an only partially populated collection
				in the referenced object.
				$this->aForm->addRecruitments($this);
			 */
		}
		return $this->aForm;
	}

	/**
	 * Declares an association between this object and a User object.
	 *
	 * @param      User $v
	 * @return     Recruitment The current object (for fluent API support)
	 * @throws     PropelException
	 */
	public function setUser(User $v = null)
	{
		if ($v === null) {
			$this->setUserId(NULL);
		} else {
			$this->setUserId($v->getId());
		}

		$this->aUser = $v;

		// Add binding for other direction of this n:n relationship.
		// If this object has already been added to the User object, it will not be re-added.
		if ($v !== null) {
			$v->addRecruitment($this);
		}

		return $this;
	}


	/**
	 * Get the associated User object
	 *
	 * @param      PropelPDO Optional Connection object.
	 * @return     User The associated User object.
	 * @throws     PropelException
	 */
	public function getUser(PropelPDO $con = null)
	{
		if ($this->aUser === null && ($this->user_id !== null)) {
			$this->aUser = UserQuery::create()->findPk($this->user_id, $con);
			/* The following can be used additionally to
				guarantee the related object contains a reference
				to this object.  This level of coupling may, however, be
				undesirable since it could result in an only partially populated collection
				in the referenced object.
				$this->aUser->addRecruitments($this);
			 */
		}
		return $this->aUser;
	}

	/**
	 * Declares an association between this object and a Group object.
	 *
	 * @param      Group $v
	 * @return     Recruitment The current object (for fluent API support)
	 * @throws     PropelException
	 */
	public function setGroup(Group $v = null)
	{
		if ($v === null) {
			$this->setGroupId(NULL);
		} else {
			$this->setGroupId($v->getId());
		}

		$this->aGroup = $v;

		// Add binding for other direction of this n:n relationship.
		// If this object has already been added to the Group object, it will not be re-added.
		if ($v !== null) {
			$v->addRecruitment($this);
		}

		return $this;
	}


	/**
	 * Get the associated Group object
	 *
	 * @param      PropelPDO Optional Connection object.
	 * @return     Group The associated Group object.
	 * @throws     PropelException
	 */
	public function getGroup(PropelPDO $con = null)
	{
		if ($this->aGroup === null && ($this->group_id !== null)) {
			$this->aGroup = GroupQuery::create()->findPk($this->group_id, $con);
			/* The following can be used additionally to
				guarantee the related object contains a reference
				to this object.  This level of coupling may, however, be
				undesirable since it could result in an only partially populated collection
				in the referenced object.
				$this->aGroup->addRecruitments($this);
			 */
		}
		return $this->aGroup;
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
		if ('RecruitmentDate' == $relationName) {
			return $this->initRecruitmentDates();
		}
		if ('RecruitmentUser' == $relationName) {
			return $this->initRecruitmentUsers();
		}
	}

	/**
	 * Clears out the collRecruitmentDates collection
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addRecruitmentDates()
	 */
	public function clearRecruitmentDates()
	{
		$this->collRecruitmentDates = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collRecruitmentDates collection.
	 *
	 * By default this just sets the collRecruitmentDates collection to an empty array (like clearcollRecruitmentDates());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @param      boolean $overrideExisting If set to true, the method call initializes
	 *                                        the collection even if it is not empty
	 *
	 * @return     void
	 */
	public function initRecruitmentDates($overrideExisting = true)
	{
		if (null !== $this->collRecruitmentDates && !$overrideExisting) {
			return;
		}
		$this->collRecruitmentDates = new PropelObjectCollection();
		$this->collRecruitmentDates->setModel('RecruitmentDate');
	}

	/**
	 * Gets an array of RecruitmentDate objects which contain a foreign key that references this object.
	 *
	 * If the $criteria is not null, it is used to always fetch the results from the database.
	 * Otherwise the results are fetched from the database the first time, then cached.
	 * Next time the same method is called without $criteria, the cached collection is returned.
	 * If this Recruitment is new, it will return
	 * an empty collection or the current collection; the criteria is ignored on a new object.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @return     PropelCollection|array RecruitmentDate[] List of RecruitmentDate objects
	 * @throws     PropelException
	 */
	public function getRecruitmentDates($criteria = null, PropelPDO $con = null)
	{
		if(null === $this->collRecruitmentDates || null !== $criteria) {
			if ($this->isNew() && null === $this->collRecruitmentDates) {
				// return empty collection
				$this->initRecruitmentDates();
			} else {
				$collRecruitmentDates = RecruitmentDateQuery::create(null, $criteria)
					->filterByRecruitment($this)
					->find($con);
				if (null !== $criteria) {
					return $collRecruitmentDates;
				}
				$this->collRecruitmentDates = $collRecruitmentDates;
			}
		}
		return $this->collRecruitmentDates;
	}

	/**
	 * Sets a collection of RecruitmentDate objects related by a one-to-many relationship
	 * to the current object.
	 * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
	 * and new objects from the given Propel collection.
	 *
	 * @param      PropelCollection $recruitmentDates A Propel collection.
	 * @param      PropelPDO $con Optional connection object
	 */
	public function setRecruitmentDates(PropelCollection $recruitmentDates, PropelPDO $con = null)
	{
		$this->recruitmentDatesScheduledForDeletion = $this->getRecruitmentDates(new Criteria(), $con)->diff($recruitmentDates);

		foreach ($recruitmentDates as $recruitmentDate) {
			// Fix issue with collection modified by reference
			if ($recruitmentDate->isNew()) {
				$recruitmentDate->setRecruitment($this);
			}
			$this->addRecruitmentDate($recruitmentDate);
		}

		$this->collRecruitmentDates = $recruitmentDates;
	}

	/**
	 * Returns the number of related RecruitmentDate objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related RecruitmentDate objects.
	 * @throws     PropelException
	 */
	public function countRecruitmentDates(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if(null === $this->collRecruitmentDates || null !== $criteria) {
			if ($this->isNew() && null === $this->collRecruitmentDates) {
				return 0;
			} else {
				$query = RecruitmentDateQuery::create(null, $criteria);
				if($distinct) {
					$query->distinct();
				}
				return $query
					->filterByRecruitment($this)
					->count($con);
			}
		} else {
			return count($this->collRecruitmentDates);
		}
	}

	/**
	 * Method called to associate a RecruitmentDate object to this object
	 * through the RecruitmentDate foreign key attribute.
	 *
	 * @param      RecruitmentDate $l RecruitmentDate
	 * @return     Recruitment The current object (for fluent API support)
	 */
	public function addRecruitmentDate(RecruitmentDate $l)
	{
		if ($this->collRecruitmentDates === null) {
			$this->initRecruitmentDates();
		}
		if (!$this->collRecruitmentDates->contains($l)) { // only add it if the **same** object is not already associated
			$this->doAddRecruitmentDate($l);
		}

		return $this;
	}

	/**
	 * @param	RecruitmentDate $recruitmentDate The recruitmentDate object to add.
	 */
	protected function doAddRecruitmentDate($recruitmentDate)
	{
		$this->collRecruitmentDates[]= $recruitmentDate;
		$recruitmentDate->setRecruitment($this);
	}

	/**
	 * Clears out the collRecruitmentUsers collection
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addRecruitmentUsers()
	 */
	public function clearRecruitmentUsers()
	{
		$this->collRecruitmentUsers = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collRecruitmentUsers collection.
	 *
	 * By default this just sets the collRecruitmentUsers collection to an empty array (like clearcollRecruitmentUsers());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @param      boolean $overrideExisting If set to true, the method call initializes
	 *                                        the collection even if it is not empty
	 *
	 * @return     void
	 */
	public function initRecruitmentUsers($overrideExisting = true)
	{
		if (null !== $this->collRecruitmentUsers && !$overrideExisting) {
			return;
		}
		$this->collRecruitmentUsers = new PropelObjectCollection();
		$this->collRecruitmentUsers->setModel('RecruitmentUser');
	}

	/**
	 * Gets an array of RecruitmentUser objects which contain a foreign key that references this object.
	 *
	 * If the $criteria is not null, it is used to always fetch the results from the database.
	 * Otherwise the results are fetched from the database the first time, then cached.
	 * Next time the same method is called without $criteria, the cached collection is returned.
	 * If this Recruitment is new, it will return
	 * an empty collection or the current collection; the criteria is ignored on a new object.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @return     PropelCollection|array RecruitmentUser[] List of RecruitmentUser objects
	 * @throws     PropelException
	 */
	public function getRecruitmentUsers($criteria = null, PropelPDO $con = null)
	{
		if(null === $this->collRecruitmentUsers || null !== $criteria) {
			if ($this->isNew() && null === $this->collRecruitmentUsers) {
				// return empty collection
				$this->initRecruitmentUsers();
			} else {
				$collRecruitmentUsers = RecruitmentUserQuery::create(null, $criteria)
					->filterByRecruitment($this)
					->find($con);
				if (null !== $criteria) {
					return $collRecruitmentUsers;
				}
				$this->collRecruitmentUsers = $collRecruitmentUsers;
			}
		}
		return $this->collRecruitmentUsers;
	}

	/**
	 * Sets a collection of RecruitmentUser objects related by a one-to-many relationship
	 * to the current object.
	 * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
	 * and new objects from the given Propel collection.
	 *
	 * @param      PropelCollection $recruitmentUsers A Propel collection.
	 * @param      PropelPDO $con Optional connection object
	 */
	public function setRecruitmentUsers(PropelCollection $recruitmentUsers, PropelPDO $con = null)
	{
		$this->recruitmentUsersScheduledForDeletion = $this->getRecruitmentUsers(new Criteria(), $con)->diff($recruitmentUsers);

		foreach ($recruitmentUsers as $recruitmentUser) {
			// Fix issue with collection modified by reference
			if ($recruitmentUser->isNew()) {
				$recruitmentUser->setRecruitment($this);
			}
			$this->addRecruitmentUser($recruitmentUser);
		}

		$this->collRecruitmentUsers = $recruitmentUsers;
	}

	/**
	 * Returns the number of related RecruitmentUser objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related RecruitmentUser objects.
	 * @throws     PropelException
	 */
	public function countRecruitmentUsers(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if(null === $this->collRecruitmentUsers || null !== $criteria) {
			if ($this->isNew() && null === $this->collRecruitmentUsers) {
				return 0;
			} else {
				$query = RecruitmentUserQuery::create(null, $criteria);
				if($distinct) {
					$query->distinct();
				}
				return $query
					->filterByRecruitment($this)
					->count($con);
			}
		} else {
			return count($this->collRecruitmentUsers);
		}
	}

	/**
	 * Method called to associate a RecruitmentUser object to this object
	 * through the RecruitmentUser foreign key attribute.
	 *
	 * @param      RecruitmentUser $l RecruitmentUser
	 * @return     Recruitment The current object (for fluent API support)
	 */
	public function addRecruitmentUser(RecruitmentUser $l)
	{
		if ($this->collRecruitmentUsers === null) {
			$this->initRecruitmentUsers();
		}
		if (!$this->collRecruitmentUsers->contains($l)) { // only add it if the **same** object is not already associated
			$this->doAddRecruitmentUser($l);
		}

		return $this;
	}

	/**
	 * @param	RecruitmentUser $recruitmentUser The recruitmentUser object to add.
	 */
	protected function doAddRecruitmentUser($recruitmentUser)
	{
		$this->collRecruitmentUsers[]= $recruitmentUser;
		$recruitmentUser->setRecruitment($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Recruitment is new, it will return
	 * an empty collection; or if this Recruitment has previously
	 * been saved, it will retrieve related RecruitmentUsers from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Recruitment.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @param      string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
	 * @return     PropelCollection|array RecruitmentUser[] List of RecruitmentUser objects
	 */
	public function getRecruitmentUsersJoinRecruitmentDate($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$query = RecruitmentUserQuery::create(null, $criteria);
		$query->joinWith('RecruitmentDate', $join_behavior);

		return $this->getRecruitmentUsers($query, $con);
	}

	/**
	 * Clears the current object and sets all attributes to their default values
	 */
	public function clear()
	{
		$this->id = null;
		$this->form_id = null;
		$this->user_id = null;
		$this->group_id = null;
		$this->name = null;
		$this->alias_name = null;
		$this->place = null;
		$this->is_active = null;
		$this->description = null;
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
			if ($this->collRecruitmentDates) {
				foreach ($this->collRecruitmentDates as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collRecruitmentUsers) {
				foreach ($this->collRecruitmentUsers as $o) {
					$o->clearAllReferences($deep);
				}
			}
		} // if ($deep)

		if ($this->collRecruitmentDates instanceof PropelCollection) {
			$this->collRecruitmentDates->clearIterator();
		}
		$this->collRecruitmentDates = null;
		if ($this->collRecruitmentUsers instanceof PropelCollection) {
			$this->collRecruitmentUsers->clearIterator();
		}
		$this->collRecruitmentUsers = null;
		$this->aForm = null;
		$this->aUser = null;
		$this->aGroup = null;
	}

	/**
	 * Return the string representation of this object
	 *
	 * @return string
	 */
	public function __toString()
	{
		return (string) $this->exportTo(RecruitmentPeer::DEFAULT_STRING_FORMAT);
	}

	// timestampable behavior
	
	/**
	 * Mark the current object so that the update date doesn't get updated during next save
	 *
	 * @return     Recruitment The current object (for fluent API support)
	 */
	public function keepUpdateDateUnchanged()
	{
		$this->modifiedColumns[] = RecruitmentPeer::UPDATED_AT;
		return $this;
	}

} // BaseRecruitment
