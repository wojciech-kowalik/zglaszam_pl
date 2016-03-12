<?php

namespace Visualnet\VisualRecruiter\FormBundle\Model\om;

use \Criteria;
use \ModelCriteria;
use \ModelJoin;
use \PDO;
use \Propel;
use \PropelCollection;
use \PropelException;
use \PropelPDO;
use Visualnet\VisualRecruiter\FormBundle\Model\Form;
use Visualnet\VisualRecruiter\FormBundle\Model\FormQuestion;
use Visualnet\VisualRecruiter\FormBundle\Model\FormQuestionPeer;
use Visualnet\VisualRecruiter\FormBundle\Model\FormQuestionQuery;
use Visualnet\VisualRecruiter\QuestionBundle\Model\Question;

/**
 * Base class that represents a query for the 'visual_form_question' table.
 *
 * 
 *
 * @method     FormQuestionQuery orderByFormId($order = Criteria::ASC) Order by the form_id column
 * @method     FormQuestionQuery orderByQuestionId($order = Criteria::ASC) Order by the question_id column
 * @method     FormQuestionQuery orderByExportName($order = Criteria::ASC) Order by the export_name column
 * @method     FormQuestionQuery orderByLabel($order = Criteria::ASC) Order by the label column
 * @method     FormQuestionQuery orderByIsRequired($order = Criteria::ASC) Order by the is_required column
 * @method     FormQuestionQuery orderByIsExport($order = Criteria::ASC) Order by the is_export column
 * @method     FormQuestionQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     FormQuestionQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 * @method     FormQuestionQuery orderBySortableRank($order = Criteria::ASC) Order by the sortable_rank column
 *
 * @method     FormQuestionQuery groupByFormId() Group by the form_id column
 * @method     FormQuestionQuery groupByQuestionId() Group by the question_id column
 * @method     FormQuestionQuery groupByExportName() Group by the export_name column
 * @method     FormQuestionQuery groupByLabel() Group by the label column
 * @method     FormQuestionQuery groupByIsRequired() Group by the is_required column
 * @method     FormQuestionQuery groupByIsExport() Group by the is_export column
 * @method     FormQuestionQuery groupByCreatedAt() Group by the created_at column
 * @method     FormQuestionQuery groupByUpdatedAt() Group by the updated_at column
 * @method     FormQuestionQuery groupBySortableRank() Group by the sortable_rank column
 *
 * @method     FormQuestionQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     FormQuestionQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     FormQuestionQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     FormQuestionQuery leftJoinForm($relationAlias = null) Adds a LEFT JOIN clause to the query using the Form relation
 * @method     FormQuestionQuery rightJoinForm($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Form relation
 * @method     FormQuestionQuery innerJoinForm($relationAlias = null) Adds a INNER JOIN clause to the query using the Form relation
 *
 * @method     FormQuestionQuery leftJoinQuestion($relationAlias = null) Adds a LEFT JOIN clause to the query using the Question relation
 * @method     FormQuestionQuery rightJoinQuestion($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Question relation
 * @method     FormQuestionQuery innerJoinQuestion($relationAlias = null) Adds a INNER JOIN clause to the query using the Question relation
 *
 * @method     FormQuestion findOne(PropelPDO $con = null) Return the first FormQuestion matching the query
 * @method     FormQuestion findOneOrCreate(PropelPDO $con = null) Return the first FormQuestion matching the query, or a new FormQuestion object populated from the query conditions when no match is found
 *
 * @method     FormQuestion findOneByFormId(int $form_id) Return the first FormQuestion filtered by the form_id column
 * @method     FormQuestion findOneByQuestionId(int $question_id) Return the first FormQuestion filtered by the question_id column
 * @method     FormQuestion findOneByExportName(string $export_name) Return the first FormQuestion filtered by the export_name column
 * @method     FormQuestion findOneByLabel(string $label) Return the first FormQuestion filtered by the label column
 * @method     FormQuestion findOneByIsRequired(boolean $is_required) Return the first FormQuestion filtered by the is_required column
 * @method     FormQuestion findOneByIsExport(boolean $is_export) Return the first FormQuestion filtered by the is_export column
 * @method     FormQuestion findOneByCreatedAt(string $created_at) Return the first FormQuestion filtered by the created_at column
 * @method     FormQuestion findOneByUpdatedAt(string $updated_at) Return the first FormQuestion filtered by the updated_at column
 * @method     FormQuestion findOneBySortableRank(int $sortable_rank) Return the first FormQuestion filtered by the sortable_rank column
 *
 * @method     array findByFormId(int $form_id) Return FormQuestion objects filtered by the form_id column
 * @method     array findByQuestionId(int $question_id) Return FormQuestion objects filtered by the question_id column
 * @method     array findByExportName(string $export_name) Return FormQuestion objects filtered by the export_name column
 * @method     array findByLabel(string $label) Return FormQuestion objects filtered by the label column
 * @method     array findByIsRequired(boolean $is_required) Return FormQuestion objects filtered by the is_required column
 * @method     array findByIsExport(boolean $is_export) Return FormQuestion objects filtered by the is_export column
 * @method     array findByCreatedAt(string $created_at) Return FormQuestion objects filtered by the created_at column
 * @method     array findByUpdatedAt(string $updated_at) Return FormQuestion objects filtered by the updated_at column
 * @method     array findBySortableRank(int $sortable_rank) Return FormQuestion objects filtered by the sortable_rank column
 *
 * @package    propel.generator.src.Visualnet.VisualRecruiter.FormBundle.Model.om
 */
abstract class BaseFormQuestionQuery extends ModelCriteria
{
	
	/**
	 * Initializes internal state of BaseFormQuestionQuery object.
	 *
	 * @param     string $dbName The dabase name
	 * @param     string $modelName The phpName of a model, e.g. 'Book'
	 * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
	 */
	public function __construct($dbName = 'default', $modelName = 'Visualnet\\VisualRecruiter\\FormBundle\\Model\\FormQuestion', $modelAlias = null)
	{
		parent::__construct($dbName, $modelName, $modelAlias);
	}

	/**
	 * Returns a new FormQuestionQuery object.
	 *
	 * @param     string $modelAlias The alias of a model in the query
	 * @param     Criteria $criteria Optional Criteria to build the query from
	 *
	 * @return    FormQuestionQuery
	 */
	public static function create($modelAlias = null, $criteria = null)
	{
		if ($criteria instanceof FormQuestionQuery) {
			return $criteria;
		}
		$query = new FormQuestionQuery();
		if (null !== $modelAlias) {
			$query->setModelAlias($modelAlias);
		}
		if ($criteria instanceof Criteria) {
			$query->mergeWith($criteria);
		}
		return $query;
	}

	/**
	 * Find object by primary key.
	 * Propel uses the instance pool to skip the database if the object exists.
	 * Go fast if the query is untouched.
	 *
	 * <code>
	 * $obj = $c->findPk(array(12, 34), $con);
	 * </code>
	 *
	 * @param     array[$form_id, $question_id] $key Primary key to use for the query
	 * @param     PropelPDO $con an optional connection object
	 *
	 * @return    FormQuestion|array|mixed the result, formatted by the current formatter
	 */
	public function findPk($key, $con = null)
	{
		if ($key === null) {
			return null;
		}
		if ((null !== ($obj = FormQuestionPeer::getInstanceFromPool(serialize(array((string) $key[0], (string) $key[1]))))) && !$this->formatter) {
			// the object is alredy in the instance pool
			return $obj;
		}
		if ($con === null) {
			$con = Propel::getConnection(FormQuestionPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}
		$this->basePreSelect($con);
		if ($this->formatter || $this->modelAlias || $this->with || $this->select
		 || $this->selectColumns || $this->asColumns || $this->selectModifiers
		 || $this->map || $this->having || $this->joins) {
			return $this->findPkComplex($key, $con);
		} else {
			return $this->findPkSimple($key, $con);
		}
	}

	/**
	 * Find object by primary key using raw SQL to go fast.
	 * Bypass doSelect() and the object formatter by using generated code.
	 *
	 * @param     mixed $key Primary key to use for the query
	 * @param     PropelPDO $con A connection object
	 *
	 * @return    FormQuestion A model object, or null if the key is not found
	 */
	protected function findPkSimple($key, $con)
	{
		$sql = 'SELECT `FORM_ID`, `QUESTION_ID`, `EXPORT_NAME`, `LABEL`, `IS_REQUIRED`, `IS_EXPORT`, `CREATED_AT`, `UPDATED_AT`, `SORTABLE_RANK` FROM `visual_form_question` WHERE `FORM_ID` = :p0 AND `QUESTION_ID` = :p1';
		try {
			$stmt = $con->prepare($sql);			
			$stmt->bindValue(':p0', $key[0], PDO::PARAM_INT);			
			$stmt->bindValue(':p1', $key[1], PDO::PARAM_INT);
			$stmt->execute();
		} catch (Exception $e) {
			Propel::log($e->getMessage(), Propel::LOG_ERR);
			throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), $e);
		}
		$obj = null;
		if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$obj = new FormQuestion();
			$obj->hydrate($row);
			FormQuestionPeer::addInstanceToPool($obj, serialize(array((string) $key[0], (string) $key[1])));
		}
		$stmt->closeCursor();

		return $obj;
	}

	/**
	 * Find object by primary key.
	 *
	 * @param     mixed $key Primary key to use for the query
	 * @param     PropelPDO $con A connection object
	 *
	 * @return    FormQuestion|array|mixed the result, formatted by the current formatter
	 */
	protected function findPkComplex($key, $con)
	{
		// As the query uses a PK condition, no limit(1) is necessary.
		$criteria = $this->isKeepQuery() ? clone $this : $this;
		$stmt = $criteria
			->filterByPrimaryKey($key)
			->doSelect($con);
		return $criteria->getFormatter()->init($criteria)->formatOne($stmt);
	}

	/**
	 * Find objects by primary key
	 * <code>
	 * $objs = $c->findPks(array(array(12, 56), array(832, 123), array(123, 456)), $con);
	 * </code>
	 * @param     array $keys Primary keys to use for the query
	 * @param     PropelPDO $con an optional connection object
	 *
	 * @return    PropelObjectCollection|array|mixed the list of results, formatted by the current formatter
	 */
	public function findPks($keys, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection($this->getDbName(), Propel::CONNECTION_READ);
		}
		$this->basePreSelect($con);
		$criteria = $this->isKeepQuery() ? clone $this : $this;
		$stmt = $criteria
			->filterByPrimaryKeys($keys)
			->doSelect($con);
		return $criteria->getFormatter()->init($criteria)->format($stmt);
	}

	/**
	 * Filter the query by primary key
	 *
	 * @param     mixed $key Primary key to use for the query
	 *
	 * @return    FormQuestionQuery The current query, for fluid interface
	 */
	public function filterByPrimaryKey($key)
	{
		$this->addUsingAlias(FormQuestionPeer::FORM_ID, $key[0], Criteria::EQUAL);
		$this->addUsingAlias(FormQuestionPeer::QUESTION_ID, $key[1], Criteria::EQUAL);

		return $this;
	}

	/**
	 * Filter the query by a list of primary keys
	 *
	 * @param     array $keys The list of primary key to use for the query
	 *
	 * @return    FormQuestionQuery The current query, for fluid interface
	 */
	public function filterByPrimaryKeys($keys)
	{
		if (empty($keys)) {
			return $this->add(null, '1<>1', Criteria::CUSTOM);
		}
		foreach ($keys as $key) {
			$cton0 = $this->getNewCriterion(FormQuestionPeer::FORM_ID, $key[0], Criteria::EQUAL);
			$cton1 = $this->getNewCriterion(FormQuestionPeer::QUESTION_ID, $key[1], Criteria::EQUAL);
			$cton0->addAnd($cton1);
			$this->addOr($cton0);
		}

		return $this;
	}

	/**
	 * Filter the query on the form_id column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByFormId(1234); // WHERE form_id = 1234
	 * $query->filterByFormId(array(12, 34)); // WHERE form_id IN (12, 34)
	 * $query->filterByFormId(array('min' => 12)); // WHERE form_id > 12
	 * </code>
	 *
	 * @see       filterByForm()
	 *
	 * @param     mixed $formId The value to use as filter.
	 *              Use scalar values for equality.
	 *              Use array values for in_array() equivalent.
	 *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    FormQuestionQuery The current query, for fluid interface
	 */
	public function filterByFormId($formId = null, $comparison = null)
	{
		if (is_array($formId) && null === $comparison) {
			$comparison = Criteria::IN;
		}
		return $this->addUsingAlias(FormQuestionPeer::FORM_ID, $formId, $comparison);
	}

	/**
	 * Filter the query on the question_id column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByQuestionId(1234); // WHERE question_id = 1234
	 * $query->filterByQuestionId(array(12, 34)); // WHERE question_id IN (12, 34)
	 * $query->filterByQuestionId(array('min' => 12)); // WHERE question_id > 12
	 * </code>
	 *
	 * @see       filterByQuestion()
	 *
	 * @param     mixed $questionId The value to use as filter.
	 *              Use scalar values for equality.
	 *              Use array values for in_array() equivalent.
	 *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    FormQuestionQuery The current query, for fluid interface
	 */
	public function filterByQuestionId($questionId = null, $comparison = null)
	{
		if (is_array($questionId) && null === $comparison) {
			$comparison = Criteria::IN;
		}
		return $this->addUsingAlias(FormQuestionPeer::QUESTION_ID, $questionId, $comparison);
	}

	/**
	 * Filter the query on the export_name column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByExportName('fooValue');   // WHERE export_name = 'fooValue'
	 * $query->filterByExportName('%fooValue%'); // WHERE export_name LIKE '%fooValue%'
	 * </code>
	 *
	 * @param     string $exportName The value to use as filter.
	 *              Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    FormQuestionQuery The current query, for fluid interface
	 */
	public function filterByExportName($exportName = null, $comparison = null)
	{
		if (null === $comparison) {
			if (is_array($exportName)) {
				$comparison = Criteria::IN;
			} elseif (preg_match('/[\%\*]/', $exportName)) {
				$exportName = str_replace('*', '%', $exportName);
				$comparison = Criteria::LIKE;
			}
		}
		return $this->addUsingAlias(FormQuestionPeer::EXPORT_NAME, $exportName, $comparison);
	}

	/**
	 * Filter the query on the label column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByLabel('fooValue');   // WHERE label = 'fooValue'
	 * $query->filterByLabel('%fooValue%'); // WHERE label LIKE '%fooValue%'
	 * </code>
	 *
	 * @param     string $label The value to use as filter.
	 *              Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    FormQuestionQuery The current query, for fluid interface
	 */
	public function filterByLabel($label = null, $comparison = null)
	{
		if (null === $comparison) {
			if (is_array($label)) {
				$comparison = Criteria::IN;
			} elseif (preg_match('/[\%\*]/', $label)) {
				$label = str_replace('*', '%', $label);
				$comparison = Criteria::LIKE;
			}
		}
		return $this->addUsingAlias(FormQuestionPeer::LABEL, $label, $comparison);
	}

	/**
	 * Filter the query on the is_required column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByIsRequired(true); // WHERE is_required = true
	 * $query->filterByIsRequired('yes'); // WHERE is_required = true
	 * </code>
	 *
	 * @param     boolean|string $isRequired The value to use as filter.
	 *              Non-boolean arguments are converted using the following rules:
	 *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
	 *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
	 *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    FormQuestionQuery The current query, for fluid interface
	 */
	public function filterByIsRequired($isRequired = null, $comparison = null)
	{
		if (is_string($isRequired)) {
			$is_required = in_array(strtolower($isRequired), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
		}
		return $this->addUsingAlias(FormQuestionPeer::IS_REQUIRED, $isRequired, $comparison);
	}

	/**
	 * Filter the query on the is_export column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByIsExport(true); // WHERE is_export = true
	 * $query->filterByIsExport('yes'); // WHERE is_export = true
	 * </code>
	 *
	 * @param     boolean|string $isExport The value to use as filter.
	 *              Non-boolean arguments are converted using the following rules:
	 *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
	 *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
	 *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    FormQuestionQuery The current query, for fluid interface
	 */
	public function filterByIsExport($isExport = null, $comparison = null)
	{
		if (is_string($isExport)) {
			$is_export = in_array(strtolower($isExport), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
		}
		return $this->addUsingAlias(FormQuestionPeer::IS_EXPORT, $isExport, $comparison);
	}

	/**
	 * Filter the query on the created_at column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByCreatedAt('2011-03-14'); // WHERE created_at = '2011-03-14'
	 * $query->filterByCreatedAt('now'); // WHERE created_at = '2011-03-14'
	 * $query->filterByCreatedAt(array('max' => 'yesterday')); // WHERE created_at > '2011-03-13'
	 * </code>
	 *
	 * @param     mixed $createdAt The value to use as filter.
	 *              Values can be integers (unix timestamps), DateTime objects, or strings.
	 *              Empty strings are treated as NULL.
	 *              Use scalar values for equality.
	 *              Use array values for in_array() equivalent.
	 *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    FormQuestionQuery The current query, for fluid interface
	 */
	public function filterByCreatedAt($createdAt = null, $comparison = null)
	{
		if (is_array($createdAt)) {
			$useMinMax = false;
			if (isset($createdAt['min'])) {
				$this->addUsingAlias(FormQuestionPeer::CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($createdAt['max'])) {
				$this->addUsingAlias(FormQuestionPeer::CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(FormQuestionPeer::CREATED_AT, $createdAt, $comparison);
	}

	/**
	 * Filter the query on the updated_at column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByUpdatedAt('2011-03-14'); // WHERE updated_at = '2011-03-14'
	 * $query->filterByUpdatedAt('now'); // WHERE updated_at = '2011-03-14'
	 * $query->filterByUpdatedAt(array('max' => 'yesterday')); // WHERE updated_at > '2011-03-13'
	 * </code>
	 *
	 * @param     mixed $updatedAt The value to use as filter.
	 *              Values can be integers (unix timestamps), DateTime objects, or strings.
	 *              Empty strings are treated as NULL.
	 *              Use scalar values for equality.
	 *              Use array values for in_array() equivalent.
	 *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    FormQuestionQuery The current query, for fluid interface
	 */
	public function filterByUpdatedAt($updatedAt = null, $comparison = null)
	{
		if (is_array($updatedAt)) {
			$useMinMax = false;
			if (isset($updatedAt['min'])) {
				$this->addUsingAlias(FormQuestionPeer::UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($updatedAt['max'])) {
				$this->addUsingAlias(FormQuestionPeer::UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(FormQuestionPeer::UPDATED_AT, $updatedAt, $comparison);
	}

	/**
	 * Filter the query on the sortable_rank column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterBySortableRank(1234); // WHERE sortable_rank = 1234
	 * $query->filterBySortableRank(array(12, 34)); // WHERE sortable_rank IN (12, 34)
	 * $query->filterBySortableRank(array('min' => 12)); // WHERE sortable_rank > 12
	 * </code>
	 *
	 * @param     mixed $sortableRank The value to use as filter.
	 *              Use scalar values for equality.
	 *              Use array values for in_array() equivalent.
	 *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    FormQuestionQuery The current query, for fluid interface
	 */
	public function filterBySortableRank($sortableRank = null, $comparison = null)
	{
		if (is_array($sortableRank)) {
			$useMinMax = false;
			if (isset($sortableRank['min'])) {
				$this->addUsingAlias(FormQuestionPeer::SORTABLE_RANK, $sortableRank['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($sortableRank['max'])) {
				$this->addUsingAlias(FormQuestionPeer::SORTABLE_RANK, $sortableRank['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(FormQuestionPeer::SORTABLE_RANK, $sortableRank, $comparison);
	}

	/**
	 * Filter the query by a related Form object
	 *
	 * @param     Form|PropelCollection $form The related object(s) to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    FormQuestionQuery The current query, for fluid interface
	 */
	public function filterByForm($form, $comparison = null)
	{
		if ($form instanceof Form) {
			return $this
				->addUsingAlias(FormQuestionPeer::FORM_ID, $form->getId(), $comparison);
		} elseif ($form instanceof PropelCollection) {
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
			return $this
				->addUsingAlias(FormQuestionPeer::FORM_ID, $form->toKeyValue('PrimaryKey', 'Id'), $comparison);
		} else {
			throw new PropelException('filterByForm() only accepts arguments of type Form or PropelCollection');
		}
	}

	/**
	 * Adds a JOIN clause to the query using the Form relation
	 *
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    FormQuestionQuery The current query, for fluid interface
	 */
	public function joinForm($relationAlias = null, $joinType = Criteria::INNER_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('Form');

		// create a ModelJoin object for this join
		$join = new ModelJoin();
		$join->setJoinType($joinType);
		$join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
		if ($previousJoin = $this->getPreviousJoin()) {
			$join->setPreviousJoin($previousJoin);
		}

		// add the ModelJoin to the current object
		if($relationAlias) {
			$this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
			$this->addJoinObject($join, $relationAlias);
		} else {
			$this->addJoinObject($join, 'Form');
		}

		return $this;
	}

	/**
	 * Use the Form relation Form object
	 *
	 * @see       useQuery()
	 *
	 * @param     string $relationAlias optional alias for the relation,
	 *                                   to be used as main alias in the secondary query
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    \Visualnet\VisualRecruiter\FormBundle\Model\FormQuery A secondary query class using the current class as primary query
	 */
	public function useFormQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
	{
		return $this
			->joinForm($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'Form', '\Visualnet\VisualRecruiter\FormBundle\Model\FormQuery');
	}

	/**
	 * Filter the query by a related Question object
	 *
	 * @param     Question|PropelCollection $question The related object(s) to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    FormQuestionQuery The current query, for fluid interface
	 */
	public function filterByQuestion($question, $comparison = null)
	{
		if ($question instanceof Question) {
			return $this
				->addUsingAlias(FormQuestionPeer::QUESTION_ID, $question->getId(), $comparison);
		} elseif ($question instanceof PropelCollection) {
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
			return $this
				->addUsingAlias(FormQuestionPeer::QUESTION_ID, $question->toKeyValue('PrimaryKey', 'Id'), $comparison);
		} else {
			throw new PropelException('filterByQuestion() only accepts arguments of type Question or PropelCollection');
		}
	}

	/**
	 * Adds a JOIN clause to the query using the Question relation
	 *
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    FormQuestionQuery The current query, for fluid interface
	 */
	public function joinQuestion($relationAlias = null, $joinType = Criteria::INNER_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('Question');

		// create a ModelJoin object for this join
		$join = new ModelJoin();
		$join->setJoinType($joinType);
		$join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
		if ($previousJoin = $this->getPreviousJoin()) {
			$join->setPreviousJoin($previousJoin);
		}

		// add the ModelJoin to the current object
		if($relationAlias) {
			$this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
			$this->addJoinObject($join, $relationAlias);
		} else {
			$this->addJoinObject($join, 'Question');
		}

		return $this;
	}

	/**
	 * Use the Question relation Question object
	 *
	 * @see       useQuery()
	 *
	 * @param     string $relationAlias optional alias for the relation,
	 *                                   to be used as main alias in the secondary query
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    \Visualnet\VisualRecruiter\QuestionBundle\Model\QuestionQuery A secondary query class using the current class as primary query
	 */
	public function useQuestionQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
	{
		return $this
			->joinQuestion($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'Question', '\Visualnet\VisualRecruiter\QuestionBundle\Model\QuestionQuery');
	}

	/**
	 * Exclude object from result
	 *
	 * @param     FormQuestion $formQuestion Object to remove from the list of results
	 *
	 * @return    FormQuestionQuery The current query, for fluid interface
	 */
	public function prune($formQuestion = null)
	{
		if ($formQuestion) {
			$this->addCond('pruneCond0', $this->getAliasedColName(FormQuestionPeer::FORM_ID), $formQuestion->getFormId(), Criteria::NOT_EQUAL);
			$this->addCond('pruneCond1', $this->getAliasedColName(FormQuestionPeer::QUESTION_ID), $formQuestion->getQuestionId(), Criteria::NOT_EQUAL);
			$this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
		}

		return $this;
	}

	// timestampable behavior
	
	/**
	 * Filter by the latest updated
	 *
	 * @param      int $nbDays Maximum age of the latest update in days
	 *
	 * @return     FormQuestionQuery The current query, for fluid interface
	 */
	public function recentlyUpdated($nbDays = 7)
	{
		return $this->addUsingAlias(FormQuestionPeer::UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
	}
	
	/**
	 * Filter by the latest created
	 *
	 * @param      int $nbDays Maximum age of in days
	 *
	 * @return     FormQuestionQuery The current query, for fluid interface
	 */
	public function recentlyCreated($nbDays = 7)
	{
		return $this->addUsingAlias(FormQuestionPeer::CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
	}
	
	/**
	 * Order by update date desc
	 *
	 * @return     FormQuestionQuery The current query, for fluid interface
	 */
	public function lastUpdatedFirst()
	{
		return $this->addDescendingOrderByColumn(FormQuestionPeer::UPDATED_AT);
	}
	
	/**
	 * Order by update date asc
	 *
	 * @return     FormQuestionQuery The current query, for fluid interface
	 */
	public function firstUpdatedFirst()
	{
		return $this->addAscendingOrderByColumn(FormQuestionPeer::UPDATED_AT);
	}
	
	/**
	 * Order by create date desc
	 *
	 * @return     FormQuestionQuery The current query, for fluid interface
	 */
	public function lastCreatedFirst()
	{
		return $this->addDescendingOrderByColumn(FormQuestionPeer::CREATED_AT);
	}
	
	/**
	 * Order by create date asc
	 *
	 * @return     FormQuestionQuery The current query, for fluid interface
	 */
	public function firstCreatedFirst()
	{
		return $this->addAscendingOrderByColumn(FormQuestionPeer::CREATED_AT);
	}

	// sortable behavior
	
	/**
	 * Returns the objects in a certain list, from the list scope
	 *
	 * @param     int $scope		Scope to determine which objects node to return
	 *
	 * @return    FormQuestionQuery The current query, for fluid interface
	 */
	public function inList($scope = null)
	{
		return $this->addUsingAlias(FormQuestionPeer::SCOPE_COL, $scope, Criteria::EQUAL);
	}
	
	/**
	 * Filter the query based on a rank in the list
	 *
	 * @param     integer   $rank rank
	 * @param     int $scope		Scope to determine which suite to consider
	 *
	 * @return    FormQuestionQuery The current query, for fluid interface
	 */
	public function filterByRank($rank, $scope = null)
	{
		return $this
			->inList($scope)
			->addUsingAlias(FormQuestionPeer::RANK_COL, $rank, Criteria::EQUAL);
	}
	
	/**
	 * Order the query based on the rank in the list.
	 * Using the default $order, returns the item with the lowest rank first
	 *
	 * @param     string $order either Criteria::ASC (default) or Criteria::DESC
	 *
	 * @return    FormQuestionQuery The current query, for fluid interface
	 */
	public function orderByRank($order = Criteria::ASC)
	{
		$order = strtoupper($order);
		switch ($order) {
			case Criteria::ASC:
				return $this->addAscendingOrderByColumn($this->getAliasedColName(FormQuestionPeer::RANK_COL));
				break;
			case Criteria::DESC:
				return $this->addDescendingOrderByColumn($this->getAliasedColName(FormQuestionPeer::RANK_COL));
				break;
			default:
				throw new PropelException('FormQuestionQuery::orderBy() only accepts "asc" or "desc" as argument');
		}
	}
	
	/**
	 * Get an item from the list based on its rank
	 *
	 * @param     integer   $rank rank
	 * @param     int $scope		Scope to determine which suite to consider
	 * @param     PropelPDO $con optional connection
	 *
	 * @return    FormQuestion
	 */
	public function findOneByRank($rank, $scope = null, PropelPDO $con = null)
	{
		return $this
			->filterByRank($rank, $scope)
			->findOne($con);
	}
	
	/**
	 * Returns a list of objects
	 *
	 * @param      int $scope		Scope to determine which list to return
	 * @param      PropelPDO $con	Connection to use.
	 *
	 * @return     mixed the list of results, formatted by the current formatter
	 */
	public function findList($scope = null, $con = null)
	{
		return $this
			->inList($scope)
			->orderByRank()
			->find($con);
	}
	
	/**
	 * Get the highest rank
	 * 
	 * @param      int $scope		Scope to determine which suite to consider
	 * @param     PropelPDO optional connection
	 *
	 * @return    integer highest position
	 */
	public function getMaxRank($scope = null, PropelPDO $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(FormQuestionPeer::DATABASE_NAME);
		}
		// shift the objects with a position lower than the one of object
		$this->addSelectColumn('MAX(' . FormQuestionPeer::RANK_COL . ')');
		$this->add(FormQuestionPeer::SCOPE_COL, $scope, Criteria::EQUAL);
		$stmt = $this->doSelect($con);
	
		return $stmt->fetchColumn();
	}
	
	/**
	 * Reorder a set of sortable objects based on a list of id/position
	 * Beware that there is no check made on the positions passed
	 * So incoherent positions will result in an incoherent list
	 *
	 * @param     array     $order id => rank pairs
	 * @param     PropelPDO $con   optional connection
	 *
	 * @return    boolean true if the reordering took place, false if a database problem prevented it
	 */
	public function reorder(array $order, PropelPDO $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(FormQuestionPeer::DATABASE_NAME);
		}
	
		$con->beginTransaction();
		try {
			$ids = array_keys($order);
			$objects = $this->findPks($ids, $con);
			foreach ($objects as $object) {
				$pk = $object->getPrimaryKey();
				if ($object->getSortableRank() != $order[$pk]) {
					$object->setSortableRank($order[$pk]);
					$object->save($con);
				}
			}
			$con->commit();
	
			return true;
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

} // BaseFormQuestionQuery