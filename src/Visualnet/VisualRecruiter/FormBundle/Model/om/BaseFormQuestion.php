<?php

namespace Visualnet\VisualRecruiter\FormBundle\Model\om;

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
use Visualnet\VisualRecruiter\FormBundle\Model\Form;
use Visualnet\VisualRecruiter\FormBundle\Model\FormQuery;
use Visualnet\VisualRecruiter\FormBundle\Model\FormQuestionPeer;
use Visualnet\VisualRecruiter\FormBundle\Model\FormQuestionQuery;
use Visualnet\VisualRecruiter\QuestionBundle\Model\Question;
use Visualnet\VisualRecruiter\QuestionBundle\Model\QuestionQuery;

/**
 * Base class that represents a row from the 'visual_form_question' table.
 *
 * 
 *
 * @package    propel.generator.src.Visualnet.VisualRecruiter.FormBundle.Model.om
 */
abstract class BaseFormQuestion extends BaseObject  implements Persistent
{

	/**
	 * Peer class name
	 */
	const PEER = 'Visualnet\\VisualRecruiter\\FormBundle\\Model\\FormQuestionPeer';

	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        FormQuestionPeer
	 */
	protected static $peer;

	/**
	 * The flag var to prevent infinit loop in deep copy
	 * @var       boolean
	 */
	protected $startCopy = false;

	/**
	 * The value for the form_id field.
	 * @var        int
	 */
	protected $form_id;

	/**
	 * The value for the question_id field.
	 * @var        int
	 */
	protected $question_id;

	/**
	 * The value for the export_name field.
	 * @var        string
	 */
	protected $export_name;

	/**
	 * The value for the label field.
	 * @var        string
	 */
	protected $label;

	/**
	 * The value for the is_required field.
	 * Note: this column has a database default value of: false
	 * @var        boolean
	 */
	protected $is_required;

	/**
	 * The value for the is_export field.
	 * Note: this column has a database default value of: false
	 * @var        boolean
	 */
	protected $is_export;

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
	 * @var        Form
	 */
	protected $aForm;

	/**
	 * @var        Question
	 */
	protected $aQuestion;

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
	 * Applies default values to this object.
	 * This method should be called from the object's constructor (or
	 * equivalent initialization method).
	 * @see        __construct()
	 */
	public function applyDefaultValues()
	{
		$this->is_required = false;
		$this->is_export = false;
	}

	/**
	 * Initializes internal state of BaseFormQuestion object.
	 * @see        applyDefaults()
	 */
	public function __construct()
	{
		parent::__construct();
		$this->applyDefaultValues();
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
	 * Get the [question_id] column value.
	 * 
	 * @return     int
	 */
	public function getQuestionId()
	{
		return $this->question_id;
	}

	/**
	 * Get the [export_name] column value.
	 * 
	 * @return     string
	 */
	public function getExportName()
	{
		return $this->export_name;
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
	 * Get the [is_required] column value.
	 * 
	 * @return     boolean
	 */
	public function getIsRequired()
	{
		return $this->is_required;
	}

	/**
	 * Get the [is_export] column value.
	 * 
	 * @return     boolean
	 */
	public function getIsExport()
	{
		return $this->is_export;
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
	 * Set the value of [form_id] column.
	 * 
	 * @param      int $v new value
	 * @return     FormQuestion The current object (for fluent API support)
	 */
	public function setFormId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->form_id !== $v) {
			$this->form_id = $v;
			$this->modifiedColumns[] = FormQuestionPeer::FORM_ID;
		}

		if ($this->aForm !== null && $this->aForm->getId() !== $v) {
			$this->aForm = null;
		}

		return $this;
	} // setFormId()

	/**
	 * Set the value of [question_id] column.
	 * 
	 * @param      int $v new value
	 * @return     FormQuestion The current object (for fluent API support)
	 */
	public function setQuestionId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->question_id !== $v) {
			$this->question_id = $v;
			$this->modifiedColumns[] = FormQuestionPeer::QUESTION_ID;
		}

		if ($this->aQuestion !== null && $this->aQuestion->getId() !== $v) {
			$this->aQuestion = null;
		}

		return $this;
	} // setQuestionId()

	/**
	 * Set the value of [export_name] column.
	 * 
	 * @param      string $v new value
	 * @return     FormQuestion The current object (for fluent API support)
	 */
	public function setExportName($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->export_name !== $v) {
			$this->export_name = $v;
			$this->modifiedColumns[] = FormQuestionPeer::EXPORT_NAME;
		}

		return $this;
	} // setExportName()

	/**
	 * Set the value of [label] column.
	 * 
	 * @param      string $v new value
	 * @return     FormQuestion The current object (for fluent API support)
	 */
	public function setLabel($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->label !== $v) {
			$this->label = $v;
			$this->modifiedColumns[] = FormQuestionPeer::LABEL;
		}

		return $this;
	} // setLabel()

	/**
	 * Sets the value of the [is_required] column.
	 * Non-boolean arguments are converted using the following rules:
	 *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
	 *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
	 * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
	 * 
	 * @param      boolean|integer|string $v The new value
	 * @return     FormQuestion The current object (for fluent API support)
	 */
	public function setIsRequired($v)
	{
		if ($v !== null) {
			if (is_string($v)) {
				$v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
			} else {
				$v = (boolean) $v;
			}
		}

		if ($this->is_required !== $v) {
			$this->is_required = $v;
			$this->modifiedColumns[] = FormQuestionPeer::IS_REQUIRED;
		}

		return $this;
	} // setIsRequired()

	/**
	 * Sets the value of the [is_export] column.
	 * Non-boolean arguments are converted using the following rules:
	 *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
	 *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
	 * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
	 * 
	 * @param      boolean|integer|string $v The new value
	 * @return     FormQuestion The current object (for fluent API support)
	 */
	public function setIsExport($v)
	{
		if ($v !== null) {
			if (is_string($v)) {
				$v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
			} else {
				$v = (boolean) $v;
			}
		}

		if ($this->is_export !== $v) {
			$this->is_export = $v;
			$this->modifiedColumns[] = FormQuestionPeer::IS_EXPORT;
		}

		return $this;
	} // setIsExport()

	/**
	 * Sets the value of [created_at] column to a normalized version of the date/time value specified.
	 * 
	 * @param      mixed $v string, integer (timestamp), or DateTime value.
	 *               Empty strings are treated as NULL.
	 * @return     FormQuestion The current object (for fluent API support)
	 */
	public function setCreatedAt($v)
	{
		$dt = PropelDateTime::newInstance($v, null, 'DateTime');
		if ($this->created_at !== null || $dt !== null) {
			$currentDateAsString = ($this->created_at !== null && $tmpDt = new DateTime($this->created_at)) ? $tmpDt->format('Y-m-d H:i:s') : null;
			$newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
			if ($currentDateAsString !== $newDateAsString) {
				$this->created_at = $newDateAsString;
				$this->modifiedColumns[] = FormQuestionPeer::CREATED_AT;
			}
		} // if either are not null

		return $this;
	} // setCreatedAt()

	/**
	 * Sets the value of [updated_at] column to a normalized version of the date/time value specified.
	 * 
	 * @param      mixed $v string, integer (timestamp), or DateTime value.
	 *               Empty strings are treated as NULL.
	 * @return     FormQuestion The current object (for fluent API support)
	 */
	public function setUpdatedAt($v)
	{
		$dt = PropelDateTime::newInstance($v, null, 'DateTime');
		if ($this->updated_at !== null || $dt !== null) {
			$currentDateAsString = ($this->updated_at !== null && $tmpDt = new DateTime($this->updated_at)) ? $tmpDt->format('Y-m-d H:i:s') : null;
			$newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
			if ($currentDateAsString !== $newDateAsString) {
				$this->updated_at = $newDateAsString;
				$this->modifiedColumns[] = FormQuestionPeer::UPDATED_AT;
			}
		} // if either are not null

		return $this;
	} // setUpdatedAt()

	/**
	 * Set the value of [sortable_rank] column.
	 * 
	 * @param      int $v new value
	 * @return     FormQuestion The current object (for fluent API support)
	 */
	public function setSortableRank($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->sortable_rank !== $v) {
			$this->sortable_rank = $v;
			$this->modifiedColumns[] = FormQuestionPeer::SORTABLE_RANK;
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
			if ($this->is_required !== false) {
				return false;
			}

			if ($this->is_export !== false) {
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

			$this->form_id = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
			$this->question_id = ($row[$startcol + 1] !== null) ? (int) $row[$startcol + 1] : null;
			$this->export_name = ($row[$startcol + 2] !== null) ? (string) $row[$startcol + 2] : null;
			$this->label = ($row[$startcol + 3] !== null) ? (string) $row[$startcol + 3] : null;
			$this->is_required = ($row[$startcol + 4] !== null) ? (boolean) $row[$startcol + 4] : null;
			$this->is_export = ($row[$startcol + 5] !== null) ? (boolean) $row[$startcol + 5] : null;
			$this->created_at = ($row[$startcol + 6] !== null) ? (string) $row[$startcol + 6] : null;
			$this->updated_at = ($row[$startcol + 7] !== null) ? (string) $row[$startcol + 7] : null;
			$this->sortable_rank = ($row[$startcol + 8] !== null) ? (int) $row[$startcol + 8] : null;
			$this->resetModified();

			$this->setNew(false);

			if ($rehydrate) {
				$this->ensureConsistency();
			}

			return $startcol + 9; // 9 = FormQuestionPeer::NUM_HYDRATE_COLUMNS.

		} catch (Exception $e) {
			throw new PropelException("Error populating FormQuestion object", $e);
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
		if ($this->aQuestion !== null && $this->question_id !== $this->aQuestion->getId()) {
			$this->aQuestion = null;
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
			$con = Propel::getConnection(FormQuestionPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		// We don't need to alter the object instance pool; we're just modifying this instance
		// already in the pool.

		$stmt = FormQuestionPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
		$row = $stmt->fetch(PDO::FETCH_NUM);
		$stmt->closeCursor();
		if (!$row) {
			throw new PropelException('Cannot find matching row in the database to reload object values.');
		}
		$this->hydrate($row, 0, true); // rehydrate

		if ($deep) {  // also de-associate any related objects?

			$this->aForm = null;
			$this->aQuestion = null;
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
			$con = Propel::getConnection(FormQuestionPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}

		$con->beginTransaction();
		try {
			$deleteQuery = FormQuestionQuery::create()
				->filterByPrimaryKey($this->getPrimaryKey());
			$ret = $this->preDelete($con);
			// sortable behavior
			
			FormQuestionPeer::shiftRank(-1, $this->getSortableRank() + 1, null, $this->getFormId(), $con);
			FormQuestionPeer::clearInstancePool();

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
			$con = Propel::getConnection(FormQuestionPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
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
				if (!$this->isColumnModified(FormQuestionPeer::CREATED_AT)) {
					$this->setCreatedAt(time());
				}
				if (!$this->isColumnModified(FormQuestionPeer::UPDATED_AT)) {
					$this->setUpdatedAt(time());
				}
				// sortable behavior
				if (!$this->isColumnModified(FormQuestionPeer::RANK_COL)) {
					$this->setSortableRank(FormQuestionQuery::create()->getMaxRank($this->getFormId(), $con) + 1);
				}

			} else {
				$ret = $ret && $this->preUpdate($con);
				// timestampable behavior
				if ($this->isModified() && !$this->isColumnModified(FormQuestionPeer::UPDATED_AT)) {
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
				FormQuestionPeer::addInstanceToPool($this);
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

			if ($this->aQuestion !== null) {
				if ($this->aQuestion->isModified() || $this->aQuestion->isNew()) {
					$affectedRows += $this->aQuestion->save($con);
				}
				$this->setQuestion($this->aQuestion);
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


		 // check the columns in natural order for more readable SQL queries
		if ($this->isColumnModified(FormQuestionPeer::FORM_ID)) {
			$modifiedColumns[':p' . $index++]  = '`FORM_ID`';
		}
		if ($this->isColumnModified(FormQuestionPeer::QUESTION_ID)) {
			$modifiedColumns[':p' . $index++]  = '`QUESTION_ID`';
		}
		if ($this->isColumnModified(FormQuestionPeer::EXPORT_NAME)) {
			$modifiedColumns[':p' . $index++]  = '`EXPORT_NAME`';
		}
		if ($this->isColumnModified(FormQuestionPeer::LABEL)) {
			$modifiedColumns[':p' . $index++]  = '`LABEL`';
		}
		if ($this->isColumnModified(FormQuestionPeer::IS_REQUIRED)) {
			$modifiedColumns[':p' . $index++]  = '`IS_REQUIRED`';
		}
		if ($this->isColumnModified(FormQuestionPeer::IS_EXPORT)) {
			$modifiedColumns[':p' . $index++]  = '`IS_EXPORT`';
		}
		if ($this->isColumnModified(FormQuestionPeer::CREATED_AT)) {
			$modifiedColumns[':p' . $index++]  = '`CREATED_AT`';
		}
		if ($this->isColumnModified(FormQuestionPeer::UPDATED_AT)) {
			$modifiedColumns[':p' . $index++]  = '`UPDATED_AT`';
		}
		if ($this->isColumnModified(FormQuestionPeer::SORTABLE_RANK)) {
			$modifiedColumns[':p' . $index++]  = '`SORTABLE_RANK`';
		}

		$sql = sprintf(
			'INSERT INTO `visual_form_question` (%s) VALUES (%s)',
			implode(', ', $modifiedColumns),
			implode(', ', array_keys($modifiedColumns))
		);

		try {
			$stmt = $con->prepare($sql);
			foreach ($modifiedColumns as $identifier => $columnName) {
				switch ($columnName) {
					case '`FORM_ID`':						
						$stmt->bindValue($identifier, $this->form_id, PDO::PARAM_INT);
						break;
					case '`QUESTION_ID`':						
						$stmt->bindValue($identifier, $this->question_id, PDO::PARAM_INT);
						break;
					case '`EXPORT_NAME`':						
						$stmt->bindValue($identifier, $this->export_name, PDO::PARAM_STR);
						break;
					case '`LABEL`':						
						$stmt->bindValue($identifier, $this->label, PDO::PARAM_STR);
						break;
					case '`IS_REQUIRED`':
						$stmt->bindValue($identifier, (int) $this->is_required, PDO::PARAM_INT);
						break;
					case '`IS_EXPORT`':
						$stmt->bindValue($identifier, (int) $this->is_export, PDO::PARAM_INT);
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

			if ($this->aQuestion !== null) {
				if (!$this->aQuestion->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aQuestion->getValidationFailures());
				}
			}


			if (($retval = FormQuestionPeer::doValidate($this, $columns)) !== true) {
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
		$pos = FormQuestionPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getFormId();
				break;
			case 1:
				return $this->getQuestionId();
				break;
			case 2:
				return $this->getExportName();
				break;
			case 3:
				return $this->getLabel();
				break;
			case 4:
				return $this->getIsRequired();
				break;
			case 5:
				return $this->getIsExport();
				break;
			case 6:
				return $this->getCreatedAt();
				break;
			case 7:
				return $this->getUpdatedAt();
				break;
			case 8:
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
		if (isset($alreadyDumpedObjects['FormQuestion'][serialize($this->getPrimaryKey())])) {
			return '*RECURSION*';
		}
		$alreadyDumpedObjects['FormQuestion'][serialize($this->getPrimaryKey())] = true;
		$keys = FormQuestionPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getFormId(),
			$keys[1] => $this->getQuestionId(),
			$keys[2] => $this->getExportName(),
			$keys[3] => $this->getLabel(),
			$keys[4] => $this->getIsRequired(),
			$keys[5] => $this->getIsExport(),
			$keys[6] => $this->getCreatedAt(),
			$keys[7] => $this->getUpdatedAt(),
			$keys[8] => $this->getSortableRank(),
		);
		if ($includeForeignObjects) {
			if (null !== $this->aForm) {
				$result['Form'] = $this->aForm->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
			}
			if (null !== $this->aQuestion) {
				$result['Question'] = $this->aQuestion->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
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
		$pos = FormQuestionPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setFormId($value);
				break;
			case 1:
				$this->setQuestionId($value);
				break;
			case 2:
				$this->setExportName($value);
				break;
			case 3:
				$this->setLabel($value);
				break;
			case 4:
				$this->setIsRequired($value);
				break;
			case 5:
				$this->setIsExport($value);
				break;
			case 6:
				$this->setCreatedAt($value);
				break;
			case 7:
				$this->setUpdatedAt($value);
				break;
			case 8:
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
		$keys = FormQuestionPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setFormId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setQuestionId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setExportName($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setLabel($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setIsRequired($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setIsExport($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setCreatedAt($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setUpdatedAt($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setSortableRank($arr[$keys[8]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(FormQuestionPeer::DATABASE_NAME);

		if ($this->isColumnModified(FormQuestionPeer::FORM_ID)) $criteria->add(FormQuestionPeer::FORM_ID, $this->form_id);
		if ($this->isColumnModified(FormQuestionPeer::QUESTION_ID)) $criteria->add(FormQuestionPeer::QUESTION_ID, $this->question_id);
		if ($this->isColumnModified(FormQuestionPeer::EXPORT_NAME)) $criteria->add(FormQuestionPeer::EXPORT_NAME, $this->export_name);
		if ($this->isColumnModified(FormQuestionPeer::LABEL)) $criteria->add(FormQuestionPeer::LABEL, $this->label);
		if ($this->isColumnModified(FormQuestionPeer::IS_REQUIRED)) $criteria->add(FormQuestionPeer::IS_REQUIRED, $this->is_required);
		if ($this->isColumnModified(FormQuestionPeer::IS_EXPORT)) $criteria->add(FormQuestionPeer::IS_EXPORT, $this->is_export);
		if ($this->isColumnModified(FormQuestionPeer::CREATED_AT)) $criteria->add(FormQuestionPeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(FormQuestionPeer::UPDATED_AT)) $criteria->add(FormQuestionPeer::UPDATED_AT, $this->updated_at);
		if ($this->isColumnModified(FormQuestionPeer::SORTABLE_RANK)) $criteria->add(FormQuestionPeer::SORTABLE_RANK, $this->sortable_rank);

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
		$criteria = new Criteria(FormQuestionPeer::DATABASE_NAME);
		$criteria->add(FormQuestionPeer::FORM_ID, $this->form_id);
		$criteria->add(FormQuestionPeer::QUESTION_ID, $this->question_id);

		return $criteria;
	}

	/**
	 * Returns the composite primary key for this object.
	 * The array elements will be in same order as specified in XML.
	 * @return     array
	 */
	public function getPrimaryKey()
	{
		$pks = array();
		$pks[0] = $this->getFormId();
		$pks[1] = $this->getQuestionId();

		return $pks;
	}

	/**
	 * Set the [composite] primary key.
	 *
	 * @param      array $keys The elements of the composite key (order must match the order in XML file).
	 * @return     void
	 */
	public function setPrimaryKey($keys)
	{
		$this->setFormId($keys[0]);
		$this->setQuestionId($keys[1]);
	}

	/**
	 * Returns true if the primary key for this object is null.
	 * @return     boolean
	 */
	public function isPrimaryKeyNull()
	{
		return (null === $this->getFormId()) && (null === $this->getQuestionId());
	}

	/**
	 * Sets contents of passed object to values from current object.
	 *
	 * If desired, this method can also make copies of all associated (fkey referrers)
	 * objects.
	 *
	 * @param      object $copyObj An object of FormQuestion (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
	{
		$copyObj->setFormId($this->getFormId());
		$copyObj->setQuestionId($this->getQuestionId());
		$copyObj->setExportName($this->getExportName());
		$copyObj->setLabel($this->getLabel());
		$copyObj->setIsRequired($this->getIsRequired());
		$copyObj->setIsExport($this->getIsExport());
		$copyObj->setCreatedAt($this->getCreatedAt());
		$copyObj->setUpdatedAt($this->getUpdatedAt());
		$copyObj->setSortableRank($this->getSortableRank());

		if ($deepCopy && !$this->startCopy) {
			// important: temporarily setNew(false) because this affects the behavior of
			// the getter/setter methods for fkey referrer objects.
			$copyObj->setNew(false);
			// store object hash to prevent cycle
			$this->startCopy = true;

			//unflag object copy
			$this->startCopy = false;
		} // if ($deepCopy)

		if ($makeNew) {
			$copyObj->setNew(true);
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
	 * @return     FormQuestion Clone of current object.
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
	 * @return     FormQuestionPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new FormQuestionPeer();
		}
		return self::$peer;
	}

	/**
	 * Declares an association between this object and a Form object.
	 *
	 * @param      Form $v
	 * @return     FormQuestion The current object (for fluent API support)
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
			$v->addFormQuestion($this);
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
				->filterByFormQuestion($this) // here
				->findOne($con);
			/* The following can be used additionally to
				guarantee the related object contains a reference
				to this object.  This level of coupling may, however, be
				undesirable since it could result in an only partially populated collection
				in the referenced object.
				$this->aForm->addFormQuestions($this);
			 */
		}
		return $this->aForm;
	}

	/**
	 * Declares an association between this object and a Question object.
	 *
	 * @param      Question $v
	 * @return     FormQuestion The current object (for fluent API support)
	 * @throws     PropelException
	 */
	public function setQuestion(Question $v = null)
	{
		if ($v === null) {
			$this->setQuestionId(NULL);
		} else {
			$this->setQuestionId($v->getId());
		}

		$this->aQuestion = $v;

		// Add binding for other direction of this n:n relationship.
		// If this object has already been added to the Question object, it will not be re-added.
		if ($v !== null) {
			$v->addFormQuestion($this);
		}

		return $this;
	}


	/**
	 * Get the associated Question object
	 *
	 * @param      PropelPDO Optional Connection object.
	 * @return     Question The associated Question object.
	 * @throws     PropelException
	 */
	public function getQuestion(PropelPDO $con = null)
	{
		if ($this->aQuestion === null && ($this->question_id !== null)) {
			$this->aQuestion = QuestionQuery::create()->findPk($this->question_id, $con);
			/* The following can be used additionally to
				guarantee the related object contains a reference
				to this object.  This level of coupling may, however, be
				undesirable since it could result in an only partially populated collection
				in the referenced object.
				$this->aQuestion->addFormQuestions($this);
			 */
		}
		return $this->aQuestion;
	}

	/**
	 * Clears the current object and sets all attributes to their default values
	 */
	public function clear()
	{
		$this->form_id = null;
		$this->question_id = null;
		$this->export_name = null;
		$this->label = null;
		$this->is_required = null;
		$this->is_export = null;
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
		} // if ($deep)

		$this->aForm = null;
		$this->aQuestion = null;
	}

	/**
	 * Return the string representation of this object
	 *
	 * @return string
	 */
	public function __toString()
	{
		return (string) $this->exportTo(FormQuestionPeer::DEFAULT_STRING_FORMAT);
	}

	// timestampable behavior
	
	/**
	 * Mark the current object so that the update date doesn't get updated during next save
	 *
	 * @return     FormQuestion The current object (for fluent API support)
	 */
	public function keepUpdateDateUnchanged()
	{
		$this->modifiedColumns[] = FormQuestionPeer::UPDATED_AT;
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
	 * @return    FormQuestion
	 */
	public function setRank($v)
	{
		return $this->setSortableRank($v);
	}
	
	/**
	 * Wrap the getter for scope value
	 *
	 * @return    int
	 */
	public function getScopeValue()
	{
		return $this->form_id;
	}
	
	/**
	 * Wrap the setter for scope value
	 *
	 * @param     int
	 * @return    FormQuestion
	 */
	public function setScopeValue($v)
	{
		return $this->setFormId($v);
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
		return $this->getSortableRank() == FormQuestionQuery::create()->getMaxRank($this->getFormId(), $con);
	}
	
	/**
	 * Get the next item in the list, i.e. the one for which rank is immediately higher
	 *
	 * @param     PropelPDO  $con      optional connection
	 *
	 * @return    FormQuestion
	 */
	public function getNext(PropelPDO $con = null)
	{
		return FormQuestionQuery::create()->findOneByRank($this->getSortableRank() + 1, $this->getFormId(), $con);
	}
	
	/**
	 * Get the previous item in the list, i.e. the one for which rank is immediately lower
	 *
	 * @param     PropelPDO  $con      optional connection
	 *
	 * @return    FormQuestion
	 */
	public function getPrevious(PropelPDO $con = null)
	{
		return FormQuestionQuery::create()->findOneByRank($this->getSortableRank() - 1, $this->getFormId(), $con);
	}
	
	/**
	 * Insert at specified rank
	 * The modifications are not persisted until the object is saved.
	 *
	 * @param     integer    $rank rank value
	 * @param     PropelPDO  $con      optional connection
	 *
	 * @return    FormQuestion the current object
	 *
	 * @throws    PropelException
	 */
	public function insertAtRank($rank, PropelPDO $con = null)
	{
		if (null === $this->getFormId()) {
			throw new PropelException('The scope must be defined before inserting an object in a suite');
		}
		$maxRank = FormQuestionQuery::create()->getMaxRank($this->getFormId(), $con);
		if ($rank < 1 || $rank > $maxRank + 1) {
			throw new PropelException('Invalid rank ' . $rank);
		}
		// move the object in the list, at the given rank
		$this->setSortableRank($rank);
		if ($rank != $maxRank + 1) {
			// Keep the list modification query for the save() transaction
			$this->sortableQueries []= array(
				'callable'  => array('FormQuestionPeer', 'shiftRank'),
				'arguments' => array(1, $rank, null, $this->getFormId())
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
	 * @return    FormQuestion the current object
	 *
	 * @throws    PropelException
	 */
	public function insertAtBottom(PropelPDO $con = null)
	{
		if (null === $this->getFormId()) {
			throw new PropelException('The scope must be defined before inserting an object in a suite');
		}
		$this->setSortableRank(FormQuestionQuery::create()->getMaxRank($this->getFormId(), $con) + 1);
	
		return $this;
	}
	
	/**
	 * Insert in the first rank
	 * The modifications are not persisted until the object is saved.
	 *
	 * @return    FormQuestion the current object
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
	 * @return    FormQuestion the current object
	 *
	 * @throws    PropelException
	 */
	public function moveToRank($newRank, PropelPDO $con = null)
	{
		if ($this->isNew()) {
			throw new PropelException('New objects cannot be moved. Please use insertAtRank() instead');
		}
		if ($con === null) {
			$con = Propel::getConnection(FormQuestionPeer::DATABASE_NAME);
		}
		if ($newRank < 1 || $newRank > FormQuestionQuery::create()->getMaxRank($this->getFormId(), $con)) {
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
			FormQuestionPeer::shiftRank($delta, min($oldRank, $newRank), max($oldRank, $newRank), $this->getFormId(), $con);
	
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
	 * @param     FormQuestion $object
	 * @param     PropelPDO $con optional connection
	 *
	 * @return    FormQuestion the current object
	 *
	 * @throws Exception if the database cannot execute the two updates
	 */
	public function swapWith($object, PropelPDO $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(FormQuestionPeer::DATABASE_NAME);
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
	 * @return    FormQuestion the current object
	 */
	public function moveUp(PropelPDO $con = null)
	{
		if ($this->isFirst()) {
			return $this;
		}
		if ($con === null) {
			$con = Propel::getConnection(FormQuestionPeer::DATABASE_NAME);
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
	 * @return    FormQuestion the current object
	 */
	public function moveDown(PropelPDO $con = null)
	{
		if ($this->isLast($con)) {
			return $this;
		}
		if ($con === null) {
			$con = Propel::getConnection(FormQuestionPeer::DATABASE_NAME);
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
	 * @return    FormQuestion the current object
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
			$con = Propel::getConnection(FormQuestionPeer::DATABASE_NAME);
		}
		$con->beginTransaction();
		try {
			$bottom = FormQuestionQuery::create()->getMaxRank($this->getFormId(), $con);
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
	 * @return    FormQuestion the current object
	 */
	public function removeFromList()
	{
		// Keep the list modification query for the save() transaction
		$this->sortableQueries []= array(
			'callable'  => array('FormQuestionPeer', 'shiftRank'),
			'arguments' => array(-1, $this->getSortableRank() + 1, null, $this->getFormId())
		);
		// remove the object from the list
		$this->setSortableRank(null);
		$this->setFormId(null);
	
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

} // BaseFormQuestion
