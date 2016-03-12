<?php

namespace Visualnet\VisualRecruiter\QuestionBundle\Model\om;

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
use Visualnet\VisualRecruiter\FormBundle\Model\FormQuestion;
use Visualnet\VisualRecruiter\FormBundle\Model\FormQuestionQuery;
use Visualnet\VisualRecruiter\QuestionBundle\Model\QuestionPeer;
use Visualnet\VisualRecruiter\QuestionBundle\Model\QuestionQuery;
use Visualnet\VisualRecruiter\RecruitmentBundle\Model\RecruitmentUserData;
use Visualnet\VisualRecruiter\RecruitmentBundle\Model\RecruitmentUserDataQuery;

/**
 * Base class that represents a row from the 'visual_question' table.
 *
 * 
 *
 * @package    propel.generator.src.Visualnet.VisualRecruiter.QuestionBundle.Model.om
 */
abstract class BaseQuestion extends BaseObject  implements Persistent
{

	/**
	 * Peer class name
	 */
	const PEER = 'Visualnet\\VisualRecruiter\\QuestionBundle\\Model\\QuestionPeer';

	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        QuestionPeer
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
	 * The value for the label field.
	 * @var        string
	 */
	protected $label;

	/**
	 * The value for the type field.
	 * @var        int
	 */
	protected $type;

	/**
	 * The value for the answers field.
	 * @var        string
	 */
	protected $answers;

	/**
	 * The value for the limit field.
	 * @var        int
	 */
	protected $limit;

	/**
	 * The value for the validation_rule_predefined field.
	 * @var        string
	 */
	protected $validation_rule_predefined;

	/**
	 * The value for the validation_rule_optional field.
	 * @var        string
	 */
	protected $validation_rule_optional;

	/**
	 * The value for the is_predefined field.
	 * Note: this column has a database default value of: false
	 * @var        boolean
	 */
	protected $is_predefined;

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
	 * The value for the sortable_rank field.
	 * @var        int
	 */
	protected $sortable_rank;

	/**
	 * @var        User
	 */
	protected $aUser;

	/**
	 * @var        Group
	 */
	protected $aGroup;

	/**
	 * @var        array FormQuestion[] Collection to store aggregation of FormQuestion objects.
	 */
	protected $collFormQuestions;

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

	// sortable behavior
	
	/**
	 * Queries to be executed in the save transaction
	 * @var        array
	 */
	protected $sortableQueries = array();

	/**
	 * An array of objects scheduled for deletion.
	 * @var		array
	 */
	protected $formQuestionsScheduledForDeletion = null;

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
		$this->is_predefined = false;
	}

	/**
	 * Initializes internal state of BaseQuestion object.
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
	 * Get the [label] column value.
	 * 
	 * @return     string
	 */
	public function getLabel()
	{
		return $this->label;
	}

	/**
	 * Get the [type] column value.
	 * 
	 * @return     int
	 */
	public function getType()
	{
		if (null === $this->type) {
			return null;
		}
		$valueSet = QuestionPeer::getValueSet(QuestionPeer::TYPE);
		if (!isset($valueSet[$this->type])) {
			throw new PropelException('Unknown stored enum key: ' . $this->type);
		}
		return $valueSet[$this->type];
	}

	/**
	 * Get the [answers] column value.
	 * 
	 * @return     string
	 */
	public function getAnswers()
	{
		return $this->answers;
	}

	/**
	 * Get the [limit] column value.
	 * 
	 * @return     int
	 */
	public function getLimit()
	{
		return $this->limit;
	}

	/**
	 * Get the [validation_rule_predefined] column value.
	 * 
	 * @return     string
	 */
	public function getValidationRulePredefined()
	{
		return $this->validation_rule_predefined;
	}

	/**
	 * Get the [validation_rule_optional] column value.
	 * 
	 * @return     string
	 */
	public function getValidationRuleOptional()
	{
		return $this->validation_rule_optional;
	}

	/**
	 * Get the [is_predefined] column value.
	 * 
	 * @return     boolean
	 */
	public function getIsPredefined()
	{
		return $this->is_predefined;
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
	 * Get the [sortable_rank] column value.
	 * 
	 * @return     int
	 */
	public function getSortableRank()
	{
		return $this->sortable_rank;
	}

	/**
	 * Set the value of [id] column.
	 * 
	 * @param      int $v new value
	 * @return     Question The current object (for fluent API support)
	 */
	public function setId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = QuestionPeer::ID;
		}

		return $this;
	} // setId()

	/**
	 * Set the value of [user_id] column.
	 * 
	 * @param      int $v new value
	 * @return     Question The current object (for fluent API support)
	 */
	public function setUserId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->user_id !== $v) {
			$this->user_id = $v;
			$this->modifiedColumns[] = QuestionPeer::USER_ID;
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
	 * @return     Question The current object (for fluent API support)
	 */
	public function setGroupId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->group_id !== $v) {
			$this->group_id = $v;
			$this->modifiedColumns[] = QuestionPeer::GROUP_ID;
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
	 * @return     Question The current object (for fluent API support)
	 */
	public function setName($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->name !== $v) {
			$this->name = $v;
			$this->modifiedColumns[] = QuestionPeer::NAME;
		}

		return $this;
	} // setName()

	/**
	 * Set the value of [label] column.
	 * 
	 * @param      string $v new value
	 * @return     Question The current object (for fluent API support)
	 */
	public function setLabel($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->label !== $v) {
			$this->label = $v;
			$this->modifiedColumns[] = QuestionPeer::LABEL;
		}

		return $this;
	} // setLabel()

	/**
	 * Set the value of [type] column.
	 * 
	 * @param      int $v new value
	 * @return     Question The current object (for fluent API support)
	 */
	public function setType($v)
	{
		if ($v !== null) {
			$valueSet = QuestionPeer::getValueSet(QuestionPeer::TYPE);
			if (!in_array($v, $valueSet)) {
				throw new PropelException(sprintf('Value "%s" is not accepted in this enumerated column', $v));
			}
			$v = array_search($v, $valueSet);
		}

		if ($this->type !== $v) {
			$this->type = $v;
			$this->modifiedColumns[] = QuestionPeer::TYPE;
		}

		return $this;
	} // setType()

	/**
	 * Set the value of [answers] column.
	 * 
	 * @param      string $v new value
	 * @return     Question The current object (for fluent API support)
	 */
	public function setAnswers($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->answers !== $v) {
			$this->answers = $v;
			$this->modifiedColumns[] = QuestionPeer::ANSWERS;
		}

		return $this;
	} // setAnswers()

	/**
	 * Set the value of [limit] column.
	 * 
	 * @param      int $v new value
	 * @return     Question The current object (for fluent API support)
	 */
	public function setLimit($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->limit !== $v) {
			$this->limit = $v;
			$this->modifiedColumns[] = QuestionPeer::LIMIT;
		}

		return $this;
	} // setLimit()

	/**
	 * Set the value of [validation_rule_predefined] column.
	 * 
	 * @param      string $v new value
	 * @return     Question The current object (for fluent API support)
	 */
	public function setValidationRulePredefined($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->validation_rule_predefined !== $v) {
			$this->validation_rule_predefined = $v;
			$this->modifiedColumns[] = QuestionPeer::VALIDATION_RULE_PREDEFINED;
		}

		return $this;
	} // setValidationRulePredefined()

	/**
	 * Set the value of [validation_rule_optional] column.
	 * 
	 * @param      string $v new value
	 * @return     Question The current object (for fluent API support)
	 */
	public function setValidationRuleOptional($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->validation_rule_optional !== $v) {
			$this->validation_rule_optional = $v;
			$this->modifiedColumns[] = QuestionPeer::VALIDATION_RULE_OPTIONAL;
		}

		return $this;
	} // setValidationRuleOptional()

	/**
	 * Sets the value of the [is_predefined] column.
	 * Non-boolean arguments are converted using the following rules:
	 *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
	 *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
	 * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
	 * 
	 * @param      boolean|integer|string $v The new value
	 * @return     Question The current object (for fluent API support)
	 */
	public function setIsPredefined($v)
	{
		if ($v !== null) {
			if (is_string($v)) {
				$v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
			} else {
				$v = (boolean) $v;
			}
		}

		if ($this->is_predefined !== $v) {
			$this->is_predefined = $v;
			$this->modifiedColumns[] = QuestionPeer::IS_PREDEFINED;
		}

		return $this;
	} // setIsPredefined()

	/**
	 * Sets the value of [created_at] column to a normalized version of the date/time value specified.
	 * 
	 * @param      mixed $v string, integer (timestamp), or DateTime value.
	 *               Empty strings are treated as NULL.
	 * @return     Question The current object (for fluent API support)
	 */
	public function setCreatedAt($v)
	{
		$dt = PropelDateTime::newInstance($v, null, 'DateTime');
		if ($this->created_at !== null || $dt !== null) {
			$currentDateAsString = ($this->created_at !== null && $tmpDt = new DateTime($this->created_at)) ? $tmpDt->format('Y-m-d H:i:s') : null;
			$newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
			if ($currentDateAsString !== $newDateAsString) {
				$this->created_at = $newDateAsString;
				$this->modifiedColumns[] = QuestionPeer::CREATED_AT;
			}
		} // if either are not null

		return $this;
	} // setCreatedAt()

	/**
	 * Sets the value of [updated_at] column to a normalized version of the date/time value specified.
	 * 
	 * @param      mixed $v string, integer (timestamp), or DateTime value.
	 *               Empty strings are treated as NULL.
	 * @return     Question The current object (for fluent API support)
	 */
	public function setUpdatedAt($v)
	{
		$dt = PropelDateTime::newInstance($v, null, 'DateTime');
		if ($this->updated_at !== null || $dt !== null) {
			$currentDateAsString = ($this->updated_at !== null && $tmpDt = new DateTime($this->updated_at)) ? $tmpDt->format('Y-m-d H:i:s') : null;
			$newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
			if ($currentDateAsString !== $newDateAsString) {
				$this->updated_at = $newDateAsString;
				$this->modifiedColumns[] = QuestionPeer::UPDATED_AT;
			}
		} // if either are not null

		return $this;
	} // setUpdatedAt()

	/**
	 * Set the value of [sortable_rank] column.
	 * 
	 * @param      int $v new value
	 * @return     Question The current object (for fluent API support)
	 */
	public function setSortableRank($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->sortable_rank !== $v) {
			$this->sortable_rank = $v;
			$this->modifiedColumns[] = QuestionPeer::SORTABLE_RANK;
		}

		return $this;
	} // setSortableRank()

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
			if ($this->is_predefined !== false) {
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
			$this->user_id = ($row[$startcol + 1] !== null) ? (int) $row[$startcol + 1] : null;
			$this->group_id = ($row[$startcol + 2] !== null) ? (int) $row[$startcol + 2] : null;
			$this->name = ($row[$startcol + 3] !== null) ? (string) $row[$startcol + 3] : null;
			$this->label = ($row[$startcol + 4] !== null) ? (string) $row[$startcol + 4] : null;
			$this->type = ($row[$startcol + 5] !== null) ? (int) $row[$startcol + 5] : null;
			$this->answers = ($row[$startcol + 6] !== null) ? (string) $row[$startcol + 6] : null;
			$this->limit = ($row[$startcol + 7] !== null) ? (int) $row[$startcol + 7] : null;
			$this->validation_rule_predefined = ($row[$startcol + 8] !== null) ? (string) $row[$startcol + 8] : null;
			$this->validation_rule_optional = ($row[$startcol + 9] !== null) ? (string) $row[$startcol + 9] : null;
			$this->is_predefined = ($row[$startcol + 10] !== null) ? (boolean) $row[$startcol + 10] : null;
			$this->created_at = ($row[$startcol + 11] !== null) ? (string) $row[$startcol + 11] : null;
			$this->updated_at = ($row[$startcol + 12] !== null) ? (string) $row[$startcol + 12] : null;
			$this->sortable_rank = ($row[$startcol + 13] !== null) ? (int) $row[$startcol + 13] : null;
			$this->resetModified();

			$this->setNew(false);

			if ($rehydrate) {
				$this->ensureConsistency();
			}

			return $startcol + 14; // 14 = QuestionPeer::NUM_HYDRATE_COLUMNS.

		} catch (Exception $e) {
			throw new PropelException("Error populating Question object", $e);
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
			$con = Propel::getConnection(QuestionPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		// We don't need to alter the object instance pool; we're just modifying this instance
		// already in the pool.

		$stmt = QuestionPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
		$row = $stmt->fetch(PDO::FETCH_NUM);
		$stmt->closeCursor();
		if (!$row) {
			throw new PropelException('Cannot find matching row in the database to reload object values.');
		}
		$this->hydrate($row, 0, true); // rehydrate

		if ($deep) {  // also de-associate any related objects?

			$this->aUser = null;
			$this->aGroup = null;
			$this->collFormQuestions = null;

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
			$con = Propel::getConnection(QuestionPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}

		$con->beginTransaction();
		try {
			$deleteQuery = QuestionQuery::create()
				->filterByPrimaryKey($this->getPrimaryKey());
			$ret = $this->preDelete($con);
			// sortable behavior
			
			QuestionPeer::shiftRank(-1, $this->getSortableRank() + 1, null, $con);
			QuestionPeer::clearInstancePool();

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
			$con = Propel::getConnection(QuestionPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}

		$con->beginTransaction();
		$isInsert = $this->isNew();
		try {
			$ret = $this->preSave($con);
			// sortable behavior
			$this->processSortableQueries($con);
			if ($isInsert) {
				$ret = $ret && $this->preInsert($con);
				// timestampable behavior
				if (!$this->isColumnModified(QuestionPeer::CREATED_AT)) {
					$this->setCreatedAt(time());
				}
				if (!$this->isColumnModified(QuestionPeer::UPDATED_AT)) {
					$this->setUpdatedAt(time());
				}
				// sortable behavior
				if (!$this->isColumnModified(QuestionPeer::RANK_COL)) {
					$this->setSortableRank(QuestionQuery::create()->getMaxRank($con) + 1);
				}

			} else {
				$ret = $ret && $this->preUpdate($con);
				// timestampable behavior
				if ($this->isModified() && !$this->isColumnModified(QuestionPeer::UPDATED_AT)) {
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
				QuestionPeer::addInstanceToPool($this);
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

			if ($this->formQuestionsScheduledForDeletion !== null) {
				if (!$this->formQuestionsScheduledForDeletion->isEmpty()) {
					FormQuestionQuery::create()
						->filterByPrimaryKeys($this->formQuestionsScheduledForDeletion->getPrimaryKeys(false))
						->delete($con);
					$this->formQuestionsScheduledForDeletion = null;
				}
			}

			if ($this->collFormQuestions !== null) {
				foreach ($this->collFormQuestions as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
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

		$this->modifiedColumns[] = QuestionPeer::ID;
		if (null !== $this->id) {
			throw new PropelException('Cannot insert a value for auto-increment primary key (' . QuestionPeer::ID . ')');
		}

		 // check the columns in natural order for more readable SQL queries
		if ($this->isColumnModified(QuestionPeer::ID)) {
			$modifiedColumns[':p' . $index++]  = '`ID`';
		}
		if ($this->isColumnModified(QuestionPeer::USER_ID)) {
			$modifiedColumns[':p' . $index++]  = '`USER_ID`';
		}
		if ($this->isColumnModified(QuestionPeer::GROUP_ID)) {
			$modifiedColumns[':p' . $index++]  = '`GROUP_ID`';
		}
		if ($this->isColumnModified(QuestionPeer::NAME)) {
			$modifiedColumns[':p' . $index++]  = '`NAME`';
		}
		if ($this->isColumnModified(QuestionPeer::LABEL)) {
			$modifiedColumns[':p' . $index++]  = '`LABEL`';
		}
		if ($this->isColumnModified(QuestionPeer::TYPE)) {
			$modifiedColumns[':p' . $index++]  = '`TYPE`';
		}
		if ($this->isColumnModified(QuestionPeer::ANSWERS)) {
			$modifiedColumns[':p' . $index++]  = '`ANSWERS`';
		}
		if ($this->isColumnModified(QuestionPeer::LIMIT)) {
			$modifiedColumns[':p' . $index++]  = '`LIMIT`';
		}
		if ($this->isColumnModified(QuestionPeer::VALIDATION_RULE_PREDEFINED)) {
			$modifiedColumns[':p' . $index++]  = '`VALIDATION_RULE_PREDEFINED`';
		}
		if ($this->isColumnModified(QuestionPeer::VALIDATION_RULE_OPTIONAL)) {
			$modifiedColumns[':p' . $index++]  = '`VALIDATION_RULE_OPTIONAL`';
		}
		if ($this->isColumnModified(QuestionPeer::IS_PREDEFINED)) {
			$modifiedColumns[':p' . $index++]  = '`IS_PREDEFINED`';
		}
		if ($this->isColumnModified(QuestionPeer::CREATED_AT)) {
			$modifiedColumns[':p' . $index++]  = '`CREATED_AT`';
		}
		if ($this->isColumnModified(QuestionPeer::UPDATED_AT)) {
			$modifiedColumns[':p' . $index++]  = '`UPDATED_AT`';
		}
		if ($this->isColumnModified(QuestionPeer::SORTABLE_RANK)) {
			$modifiedColumns[':p' . $index++]  = '`SORTABLE_RANK`';
		}

		$sql = sprintf(
			'INSERT INTO `visual_question` (%s) VALUES (%s)',
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
					case '`USER_ID`':						
						$stmt->bindValue($identifier, $this->user_id, PDO::PARAM_INT);
						break;
					case '`GROUP_ID`':						
						$stmt->bindValue($identifier, $this->group_id, PDO::PARAM_INT);
						break;
					case '`NAME`':						
						$stmt->bindValue($identifier, $this->name, PDO::PARAM_STR);
						break;
					case '`LABEL`':						
						$stmt->bindValue($identifier, $this->label, PDO::PARAM_STR);
						break;
					case '`TYPE`':						
						$stmt->bindValue($identifier, $this->type, PDO::PARAM_INT);
						break;
					case '`ANSWERS`':						
						$stmt->bindValue($identifier, $this->answers, PDO::PARAM_STR);
						break;
					case '`LIMIT`':						
						$stmt->bindValue($identifier, $this->limit, PDO::PARAM_INT);
						break;
					case '`VALIDATION_RULE_PREDEFINED`':						
						$stmt->bindValue($identifier, $this->validation_rule_predefined, PDO::PARAM_STR);
						break;
					case '`VALIDATION_RULE_OPTIONAL`':						
						$stmt->bindValue($identifier, $this->validation_rule_optional, PDO::PARAM_STR);
						break;
					case '`IS_PREDEFINED`':
						$stmt->bindValue($identifier, (int) $this->is_predefined, PDO::PARAM_INT);
						break;
					case '`CREATED_AT`':						
						$stmt->bindValue($identifier, $this->created_at, PDO::PARAM_STR);
						break;
					case '`UPDATED_AT`':						
						$stmt->bindValue($identifier, $this->updated_at, PDO::PARAM_STR);
						break;
					case '`SORTABLE_RANK`':						
						$stmt->bindValue($identifier, $this->sortable_rank, PDO::PARAM_INT);
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


			if (($retval = QuestionPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collFormQuestions !== null) {
					foreach ($this->collFormQuestions as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
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
		$pos = QuestionPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getUserId();
				break;
			case 2:
				return $this->getGroupId();
				break;
			case 3:
				return $this->getName();
				break;
			case 4:
				return $this->getLabel();
				break;
			case 5:
				return $this->getType();
				break;
			case 6:
				return $this->getAnswers();
				break;
			case 7:
				return $this->getLimit();
				break;
			case 8:
				return $this->getValidationRulePredefined();
				break;
			case 9:
				return $this->getValidationRuleOptional();
				break;
			case 10:
				return $this->getIsPredefined();
				break;
			case 11:
				return $this->getCreatedAt();
				break;
			case 12:
				return $this->getUpdatedAt();
				break;
			case 13:
				return $this->getSortableRank();
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
		if (isset($alreadyDumpedObjects['Question'][$this->getPrimaryKey()])) {
			return '*RECURSION*';
		}
		$alreadyDumpedObjects['Question'][$this->getPrimaryKey()] = true;
		$keys = QuestionPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getUserId(),
			$keys[2] => $this->getGroupId(),
			$keys[3] => $this->getName(),
			$keys[4] => $this->getLabel(),
			$keys[5] => $this->getType(),
			$keys[6] => $this->getAnswers(),
			$keys[7] => $this->getLimit(),
			$keys[8] => $this->getValidationRulePredefined(),
			$keys[9] => $this->getValidationRuleOptional(),
			$keys[10] => $this->getIsPredefined(),
			$keys[11] => $this->getCreatedAt(),
			$keys[12] => $this->getUpdatedAt(),
			$keys[13] => $this->getSortableRank(),
		);
		if ($includeForeignObjects) {
			if (null !== $this->aUser) {
				$result['User'] = $this->aUser->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
			}
			if (null !== $this->aGroup) {
				$result['Group'] = $this->aGroup->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
			}
			if (null !== $this->collFormQuestions) {
				$result['FormQuestions'] = $this->collFormQuestions->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
		$pos = QuestionPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setUserId($value);
				break;
			case 2:
				$this->setGroupId($value);
				break;
			case 3:
				$this->setName($value);
				break;
			case 4:
				$this->setLabel($value);
				break;
			case 5:
				$valueSet = QuestionPeer::getValueSet(QuestionPeer::TYPE);
				if (isset($valueSet[$value])) {
					$value = $valueSet[$value];
				}
				$this->setType($value);
				break;
			case 6:
				$this->setAnswers($value);
				break;
			case 7:
				$this->setLimit($value);
				break;
			case 8:
				$this->setValidationRulePredefined($value);
				break;
			case 9:
				$this->setValidationRuleOptional($value);
				break;
			case 10:
				$this->setIsPredefined($value);
				break;
			case 11:
				$this->setCreatedAt($value);
				break;
			case 12:
				$this->setUpdatedAt($value);
				break;
			case 13:
				$this->setSortableRank($value);
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
		$keys = QuestionPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setUserId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setGroupId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setName($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setLabel($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setType($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setAnswers($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setLimit($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setValidationRulePredefined($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setValidationRuleOptional($arr[$keys[9]]);
		if (array_key_exists($keys[10], $arr)) $this->setIsPredefined($arr[$keys[10]]);
		if (array_key_exists($keys[11], $arr)) $this->setCreatedAt($arr[$keys[11]]);
		if (array_key_exists($keys[12], $arr)) $this->setUpdatedAt($arr[$keys[12]]);
		if (array_key_exists($keys[13], $arr)) $this->setSortableRank($arr[$keys[13]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(QuestionPeer::DATABASE_NAME);

		if ($this->isColumnModified(QuestionPeer::ID)) $criteria->add(QuestionPeer::ID, $this->id);
		if ($this->isColumnModified(QuestionPeer::USER_ID)) $criteria->add(QuestionPeer::USER_ID, $this->user_id);
		if ($this->isColumnModified(QuestionPeer::GROUP_ID)) $criteria->add(QuestionPeer::GROUP_ID, $this->group_id);
		if ($this->isColumnModified(QuestionPeer::NAME)) $criteria->add(QuestionPeer::NAME, $this->name);
		if ($this->isColumnModified(QuestionPeer::LABEL)) $criteria->add(QuestionPeer::LABEL, $this->label);
		if ($this->isColumnModified(QuestionPeer::TYPE)) $criteria->add(QuestionPeer::TYPE, $this->type);
		if ($this->isColumnModified(QuestionPeer::ANSWERS)) $criteria->add(QuestionPeer::ANSWERS, $this->answers);
		if ($this->isColumnModified(QuestionPeer::LIMIT)) $criteria->add(QuestionPeer::LIMIT, $this->limit);
		if ($this->isColumnModified(QuestionPeer::VALIDATION_RULE_PREDEFINED)) $criteria->add(QuestionPeer::VALIDATION_RULE_PREDEFINED, $this->validation_rule_predefined);
		if ($this->isColumnModified(QuestionPeer::VALIDATION_RULE_OPTIONAL)) $criteria->add(QuestionPeer::VALIDATION_RULE_OPTIONAL, $this->validation_rule_optional);
		if ($this->isColumnModified(QuestionPeer::IS_PREDEFINED)) $criteria->add(QuestionPeer::IS_PREDEFINED, $this->is_predefined);
		if ($this->isColumnModified(QuestionPeer::CREATED_AT)) $criteria->add(QuestionPeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(QuestionPeer::UPDATED_AT)) $criteria->add(QuestionPeer::UPDATED_AT, $this->updated_at);
		if ($this->isColumnModified(QuestionPeer::SORTABLE_RANK)) $criteria->add(QuestionPeer::SORTABLE_RANK, $this->sortable_rank);

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
		$criteria = new Criteria(QuestionPeer::DATABASE_NAME);
		$criteria->add(QuestionPeer::ID, $this->id);

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
	 * @param      object $copyObj An object of Question (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
	{
		$copyObj->setUserId($this->getUserId());
		$copyObj->setGroupId($this->getGroupId());
		$copyObj->setName($this->getName());
		$copyObj->setLabel($this->getLabel());
		$copyObj->setType($this->getType());
		$copyObj->setAnswers($this->getAnswers());
		$copyObj->setLimit($this->getLimit());
		$copyObj->setValidationRulePredefined($this->getValidationRulePredefined());
		$copyObj->setValidationRuleOptional($this->getValidationRuleOptional());
		$copyObj->setIsPredefined($this->getIsPredefined());
		$copyObj->setCreatedAt($this->getCreatedAt());
		$copyObj->setUpdatedAt($this->getUpdatedAt());
		$copyObj->setSortableRank($this->getSortableRank());

		if ($deepCopy && !$this->startCopy) {
			// important: temporarily setNew(false) because this affects the behavior of
			// the getter/setter methods for fkey referrer objects.
			$copyObj->setNew(false);
			// store object hash to prevent cycle
			$this->startCopy = true;

			foreach ($this->getFormQuestions() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addFormQuestion($relObj->copy($deepCopy));
				}
			}

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
	 * @return     Question Clone of current object.
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
	 * @return     QuestionPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new QuestionPeer();
		}
		return self::$peer;
	}

	/**
	 * Declares an association between this object and a User object.
	 *
	 * @param      User $v
	 * @return     Question The current object (for fluent API support)
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
			$v->addQuestion($this);
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
				$this->aUser->addQuestions($this);
			 */
		}
		return $this->aUser;
	}

	/**
	 * Declares an association between this object and a Group object.
	 *
	 * @param      Group $v
	 * @return     Question The current object (for fluent API support)
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
			$v->addQuestion($this);
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
				$this->aGroup->addQuestions($this);
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
		if ('FormQuestion' == $relationName) {
			return $this->initFormQuestions();
		}
		if ('RecruitmentUserData' == $relationName) {
			return $this->initRecruitmentUserDatas();
		}
	}

	/**
	 * Clears out the collFormQuestions collection
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addFormQuestions()
	 */
	public function clearFormQuestions()
	{
		$this->collFormQuestions = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collFormQuestions collection.
	 *
	 * By default this just sets the collFormQuestions collection to an empty array (like clearcollFormQuestions());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @param      boolean $overrideExisting If set to true, the method call initializes
	 *                                        the collection even if it is not empty
	 *
	 * @return     void
	 */
	public function initFormQuestions($overrideExisting = true)
	{
		if (null !== $this->collFormQuestions && !$overrideExisting) {
			return;
		}
		$this->collFormQuestions = new PropelObjectCollection();
		$this->collFormQuestions->setModel('FormQuestion');
	}

	/**
	 * Gets an array of FormQuestion objects which contain a foreign key that references this object.
	 *
	 * If the $criteria is not null, it is used to always fetch the results from the database.
	 * Otherwise the results are fetched from the database the first time, then cached.
	 * Next time the same method is called without $criteria, the cached collection is returned.
	 * If this Question is new, it will return
	 * an empty collection or the current collection; the criteria is ignored on a new object.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @return     PropelCollection|array FormQuestion[] List of FormQuestion objects
	 * @throws     PropelException
	 */
	public function getFormQuestions($criteria = null, PropelPDO $con = null)
	{
		if(null === $this->collFormQuestions || null !== $criteria) {
			if ($this->isNew() && null === $this->collFormQuestions) {
				// return empty collection
				$this->initFormQuestions();
			} else {
				$collFormQuestions = FormQuestionQuery::create(null, $criteria)
					->filterByQuestion($this)
					->find($con);
				if (null !== $criteria) {
					return $collFormQuestions;
				}
				$this->collFormQuestions = $collFormQuestions;
			}
		}
		return $this->collFormQuestions;
	}

	/**
	 * Sets a collection of FormQuestion objects related by a one-to-many relationship
	 * to the current object.
	 * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
	 * and new objects from the given Propel collection.
	 *
	 * @param      PropelCollection $formQuestions A Propel collection.
	 * @param      PropelPDO $con Optional connection object
	 */
	public function setFormQuestions(PropelCollection $formQuestions, PropelPDO $con = null)
	{
		$this->formQuestionsScheduledForDeletion = $this->getFormQuestions(new Criteria(), $con)->diff($formQuestions);

		foreach ($formQuestions as $formQuestion) {
			// Fix issue with collection modified by reference
			if ($formQuestion->isNew()) {
				$formQuestion->setQuestion($this);
			}
			$this->addFormQuestion($formQuestion);
		}

		$this->collFormQuestions = $formQuestions;
	}

	/**
	 * Returns the number of related FormQuestion objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related FormQuestion objects.
	 * @throws     PropelException
	 */
	public function countFormQuestions(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if(null === $this->collFormQuestions || null !== $criteria) {
			if ($this->isNew() && null === $this->collFormQuestions) {
				return 0;
			} else {
				$query = FormQuestionQuery::create(null, $criteria);
				if($distinct) {
					$query->distinct();
				}
				return $query
					->filterByQuestion($this)
					->count($con);
			}
		} else {
			return count($this->collFormQuestions);
		}
	}

	/**
	 * Method called to associate a FormQuestion object to this object
	 * through the FormQuestion foreign key attribute.
	 *
	 * @param      FormQuestion $l FormQuestion
	 * @return     Question The current object (for fluent API support)
	 */
	public function addFormQuestion(FormQuestion $l)
	{
		if ($this->collFormQuestions === null) {
			$this->initFormQuestions();
		}
		if (!$this->collFormQuestions->contains($l)) { // only add it if the **same** object is not already associated
			$this->doAddFormQuestion($l);
		}

		return $this;
	}

	/**
	 * @param	FormQuestion $formQuestion The formQuestion object to add.
	 */
	protected function doAddFormQuestion($formQuestion)
	{
		$this->collFormQuestions[]= $formQuestion;
		$formQuestion->setQuestion($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Question is new, it will return
	 * an empty collection; or if this Question has previously
	 * been saved, it will retrieve related FormQuestions from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Question.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @param      string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
	 * @return     PropelCollection|array FormQuestion[] List of FormQuestion objects
	 */
	public function getFormQuestionsJoinForm($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$query = FormQuestionQuery::create(null, $criteria);
		$query->joinWith('Form', $join_behavior);

		return $this->getFormQuestions($query, $con);
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
	 * If this Question is new, it will return
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
					->filterByQuestion($this)
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
				$recruitmentUserData->setQuestion($this);
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
					->filterByQuestion($this)
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
	 * @return     Question The current object (for fluent API support)
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
		$recruitmentUserData->setQuestion($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Question is new, it will return
	 * an empty collection; or if this Question has previously
	 * been saved, it will retrieve related RecruitmentUserDatas from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Question.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @param      string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
	 * @return     PropelCollection|array RecruitmentUserData[] List of RecruitmentUserData objects
	 */
	public function getRecruitmentUserDatasJoinRecruitmentUser($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$query = RecruitmentUserDataQuery::create(null, $criteria);
		$query->joinWith('RecruitmentUser', $join_behavior);

		return $this->getRecruitmentUserDatas($query, $con);
	}

	/**
	 * Clears the current object and sets all attributes to their default values
	 */
	public function clear()
	{
		$this->id = null;
		$this->user_id = null;
		$this->group_id = null;
		$this->name = null;
		$this->label = null;
		$this->type = null;
		$this->answers = null;
		$this->limit = null;
		$this->validation_rule_predefined = null;
		$this->validation_rule_optional = null;
		$this->is_predefined = null;
		$this->created_at = null;
		$this->updated_at = null;
		$this->sortable_rank = null;
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
			if ($this->collFormQuestions) {
				foreach ($this->collFormQuestions as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collRecruitmentUserDatas) {
				foreach ($this->collRecruitmentUserDatas as $o) {
					$o->clearAllReferences($deep);
				}
			}
		} // if ($deep)

		if ($this->collFormQuestions instanceof PropelCollection) {
			$this->collFormQuestions->clearIterator();
		}
		$this->collFormQuestions = null;
		if ($this->collRecruitmentUserDatas instanceof PropelCollection) {
			$this->collRecruitmentUserDatas->clearIterator();
		}
		$this->collRecruitmentUserDatas = null;
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
		return (string) $this->exportTo(QuestionPeer::DEFAULT_STRING_FORMAT);
	}

	// timestampable behavior
	
	/**
	 * Mark the current object so that the update date doesn't get updated during next save
	 *
	 * @return     Question The current object (for fluent API support)
	 */
	public function keepUpdateDateUnchanged()
	{
		$this->modifiedColumns[] = QuestionPeer::UPDATED_AT;
		return $this;
	}

	// sortable behavior
	
	/**
	 * Wrap the getter for rank value
	 *
	 * @return    int
	 */
	public function getRank()
	{
		return $this->sortable_rank;
	}
	
	/**
	 * Wrap the setter for rank value
	 *
	 * @param     int
	 * @return    Question
	 */
	public function setRank($v)
	{
		return $this->setSortableRank($v);
	}
	
	/**
	 * Check if the object is first in the list, i.e. if it has 1 for rank
	 *
	 * @return    boolean
	 */
	public function isFirst()
	{
		return $this->getSortableRank() == 1;
	}
	
	/**
	 * Check if the object is last in the list, i.e. if its rank is the highest rank
	 *
	 * @param     PropelPDO  $con      optional connection
	 *
	 * @return    boolean
	 */
	public function isLast(PropelPDO $con = null)
	{
		return $this->getSortableRank() == QuestionQuery::create()->getMaxRank($con);
	}
	
	/**
	 * Get the next item in the list, i.e. the one for which rank is immediately higher
	 *
	 * @param     PropelPDO  $con      optional connection
	 *
	 * @return    Question
	 */
	public function getNext(PropelPDO $con = null)
	{
		return QuestionQuery::create()->findOneByRank($this->getSortableRank() + 1, $con);
	}
	
	/**
	 * Get the previous item in the list, i.e. the one for which rank is immediately lower
	 *
	 * @param     PropelPDO  $con      optional connection
	 *
	 * @return    Question
	 */
	public function getPrevious(PropelPDO $con = null)
	{
		return QuestionQuery::create()->findOneByRank($this->getSortableRank() - 1, $con);
	}
	
	/**
	 * Insert at specified rank
	 * The modifications are not persisted until the object is saved.
	 *
	 * @param     integer    $rank rank value
	 * @param     PropelPDO  $con      optional connection
	 *
	 * @return    Question the current object
	 *
	 * @throws    PropelException
	 */
	public function insertAtRank($rank, PropelPDO $con = null)
	{
		$maxRank = QuestionQuery::create()->getMaxRank($con);
		if ($rank < 1 || $rank > $maxRank + 1) {
			throw new PropelException('Invalid rank ' . $rank);
		}
		// move the object in the list, at the given rank
		$this->setSortableRank($rank);
		if ($rank != $maxRank + 1) {
			// Keep the list modification query for the save() transaction
			$this->sortableQueries []= array(
				'callable'  => array('QuestionPeer', 'shiftRank'),
				'arguments' => array(1, $rank, null, )
			);
		}
	
		return $this;
	}
	
	/**
	 * Insert in the last rank
	 * The modifications are not persisted until the object is saved.
	 *
	 * @param PropelPDO $con optional connection
	 *
	 * @return    Question the current object
	 *
	 * @throws    PropelException
	 */
	public function insertAtBottom(PropelPDO $con = null)
	{
		$this->setSortableRank(QuestionQuery::create()->getMaxRank($con) + 1);
	
		return $this;
	}
	
	/**
	 * Insert in the first rank
	 * The modifications are not persisted until the object is saved.
	 *
	 * @return    Question the current object
	 */
	public function insertAtTop()
	{
		return $this->insertAtRank(1);
	}
	
	/**
	 * Move the object to a new rank, and shifts the rank
	 * Of the objects inbetween the old and new rank accordingly
	 *
	 * @param     integer   $newRank rank value
	 * @param     PropelPDO $con optional connection
	 *
	 * @return    Question the current object
	 *
	 * @throws    PropelException
	 */
	public function moveToRank($newRank, PropelPDO $con = null)
	{
		if ($this->isNew()) {
			throw new PropelException('New objects cannot be moved. Please use insertAtRank() instead');
		}
		if ($con === null) {
			$con = Propel::getConnection(QuestionPeer::DATABASE_NAME);
		}
		if ($newRank < 1 || $newRank > QuestionQuery::create()->getMaxRank($con)) {
			throw new PropelException('Invalid rank ' . $newRank);
		}
	
		$oldRank = $this->getSortableRank();
		if ($oldRank == $newRank) {
			return $this;
		}
	
		$con->beginTransaction();
		try {
			// shift the objects between the old and the new rank
			$delta = ($oldRank < $newRank) ? -1 : 1;
			QuestionPeer::shiftRank($delta, min($oldRank, $newRank), max($oldRank, $newRank), $con);
	
			// move the object to its new rank
			$this->setSortableRank($newRank);
			$this->save($con);
	
			$con->commit();
			return $this;
		} catch (Exception $e) {
			$con->rollback();
			throw $e;
		}
	}
	
	/**
	 * Exchange the rank of the object with the one passed as argument, and saves both objects
	 *
	 * @param     Question $object
	 * @param     PropelPDO $con optional connection
	 *
	 * @return    Question the current object
	 *
	 * @throws Exception if the database cannot execute the two updates
	 */
	public function swapWith($object, PropelPDO $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(QuestionPeer::DATABASE_NAME);
		}
		$con->beginTransaction();
		try {
			$oldRank = $this->getSortableRank();
			$newRank = $object->getSortableRank();
			$this->setSortableRank($newRank);
			$this->save($con);
			$object->setSortableRank($oldRank);
			$object->save($con);
			$con->commit();
	
			return $this;
		} catch (Exception $e) {
			$con->rollback();
			throw $e;
		}
	}
	
	/**
	 * Move the object higher in the list, i.e. exchanges its rank with the one of the previous object
	 *
	 * @param     PropelPDO $con optional connection
	 *
	 * @return    Question the current object
	 */
	public function moveUp(PropelPDO $con = null)
	{
		if ($this->isFirst()) {
			return $this;
		}
		if ($con === null) {
			$con = Propel::getConnection(QuestionPeer::DATABASE_NAME);
		}
		$con->beginTransaction();
		try {
			$prev = $this->getPrevious($con);
			$this->swapWith($prev, $con);
			$con->commit();
	
			return $this;
		} catch (Exception $e) {
			$con->rollback();
			throw $e;
		}
	}
	
	/**
	 * Move the object higher in the list, i.e. exchanges its rank with the one of the next object
	 *
	 * @param     PropelPDO $con optional connection
	 *
	 * @return    Question the current object
	 */
	public function moveDown(PropelPDO $con = null)
	{
		if ($this->isLast($con)) {
			return $this;
		}
		if ($con === null) {
			$con = Propel::getConnection(QuestionPeer::DATABASE_NAME);
		}
		$con->beginTransaction();
		try {
			$next = $this->getNext($con);
			$this->swapWith($next, $con);
			$con->commit();
	
			return $this;
		} catch (Exception $e) {
			$con->rollback();
			throw $e;
		}
	}
	
	/**
	 * Move the object to the top of the list
	 *
	 * @param     PropelPDO $con optional connection
	 *
	 * @return    Question the current object
	 */
	public function moveToTop(PropelPDO $con = null)
	{
		if ($this->isFirst()) {
			return $this;
		}
		return $this->moveToRank(1, $con);
	}
	
	/**
	 * Move the object to the bottom of the list
	 *
	 * @param     PropelPDO $con optional connection
	 *
	 * @return integer the old object's rank
	 */
	public function moveToBottom(PropelPDO $con = null)
	{
		if ($this->isLast($con)) {
			return false;
		}
		if ($con === null) {
			$con = Propel::getConnection(QuestionPeer::DATABASE_NAME);
		}
		$con->beginTransaction();
		try {
			$bottom = QuestionQuery::create()->getMaxRank($con);
			$res = $this->moveToRank($bottom, $con);
			$con->commit();
	
			return $res;
		} catch (Exception $e) {
			$con->rollback();
			throw $e;
		}
	}
	
	/**
	 * Removes the current object from the list.
	 * The modifications are not persisted until the object is saved.
	 *
	 * @return    Question the current object
	 */
	public function removeFromList()
	{
		// Keep the list modification query for the save() transaction
		$this->sortableQueries []= array(
			'callable'  => array('QuestionPeer', 'shiftRank'),
			'arguments' => array(-1, $this->getSortableRank() + 1, null)
		);
		// remove the object from the list
		$this->setSortableRank(null);
	
		return $this;
	}
	
	/**
	 * Execute queries that were saved to be run inside the save transaction
	 */
	protected function processSortableQueries($con)
	{
		foreach ($this->sortableQueries as $query) {
			$query['arguments'][]= $con;
			call_user_func_array($query['callable'], $query['arguments']);
		}
		$this->sortableQueries = array();
	}

} // BaseQuestion
