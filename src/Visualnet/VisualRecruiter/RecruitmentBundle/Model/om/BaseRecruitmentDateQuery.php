<?php

namespace Visualnet\VisualRecruiter\RecruitmentBundle\Model\om;

use \Criteria;
use \ModelCriteria;
use \ModelJoin;
use \PDO;
use \Propel;
use \PropelCollection;
use \PropelException;
use \PropelPDO;
use Visualnet\VisualRecruiter\RecruitmentBundle\Model\Recruitment;
use Visualnet\VisualRecruiter\RecruitmentBundle\Model\RecruitmentDate;
use Visualnet\VisualRecruiter\RecruitmentBundle\Model\RecruitmentDatePeer;
use Visualnet\VisualRecruiter\RecruitmentBundle\Model\RecruitmentDateQuery;
use Visualnet\VisualRecruiter\RecruitmentBundle\Model\RecruitmentUser;

/**
 * Base class that represents a query for the 'visual_recruitment_date' table.
 *
 * 
 *
 * @method     RecruitmentDateQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     RecruitmentDateQuery orderByRecruitmentId($order = Criteria::ASC) Order by the recruitment_id column
 * @method     RecruitmentDateQuery orderByEventDateFrom($order = Criteria::ASC) Order by the event_date_from column
 * @method     RecruitmentDateQuery orderByEventDateTo($order = Criteria::ASC) Order by the event_date_to column
 * @method     RecruitmentDateQuery orderByNoActiveText($order = Criteria::ASC) Order by the no_active_text column
 * @method     RecruitmentDateQuery orderByUsedLimit($order = Criteria::ASC) Order by the used_limit column
 * @method     RecruitmentDateQuery orderBySetLimit($order = Criteria::ASC) Order by the set_limit column
 * @method     RecruitmentDateQuery orderByIsVisibleLimit($order = Criteria::ASC) Order by the is_visible_limit column
 * @method     RecruitmentDateQuery orderByIsNotSetEventDate($order = Criteria::ASC) Order by the is_not_set_event_date column
 * @method     RecruitmentDateQuery orderByIsActive($order = Criteria::ASC) Order by the is_active column
 * @method     RecruitmentDateQuery orderByIsAutomaticQualify($order = Criteria::ASC) Order by the is_automatic_qualify column
 * @method     RecruitmentDateQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     RecruitmentDateQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method     RecruitmentDateQuery groupById() Group by the id column
 * @method     RecruitmentDateQuery groupByRecruitmentId() Group by the recruitment_id column
 * @method     RecruitmentDateQuery groupByEventDateFrom() Group by the event_date_from column
 * @method     RecruitmentDateQuery groupByEventDateTo() Group by the event_date_to column
 * @method     RecruitmentDateQuery groupByNoActiveText() Group by the no_active_text column
 * @method     RecruitmentDateQuery groupByUsedLimit() Group by the used_limit column
 * @method     RecruitmentDateQuery groupBySetLimit() Group by the set_limit column
 * @method     RecruitmentDateQuery groupByIsVisibleLimit() Group by the is_visible_limit column
 * @method     RecruitmentDateQuery groupByIsNotSetEventDate() Group by the is_not_set_event_date column
 * @method     RecruitmentDateQuery groupByIsActive() Group by the is_active column
 * @method     RecruitmentDateQuery groupByIsAutomaticQualify() Group by the is_automatic_qualify column
 * @method     RecruitmentDateQuery groupByCreatedAt() Group by the created_at column
 * @method     RecruitmentDateQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method     RecruitmentDateQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     RecruitmentDateQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     RecruitmentDateQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     RecruitmentDateQuery leftJoinRecruitment($relationAlias = null) Adds a LEFT JOIN clause to the query using the Recruitment relation
 * @method     RecruitmentDateQuery rightJoinRecruitment($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Recruitment relation
 * @method     RecruitmentDateQuery innerJoinRecruitment($relationAlias = null) Adds a INNER JOIN clause to the query using the Recruitment relation
 *
 * @method     RecruitmentDateQuery leftJoinRecruitmentUser($relationAlias = null) Adds a LEFT JOIN clause to the query using the RecruitmentUser relation
 * @method     RecruitmentDateQuery rightJoinRecruitmentUser($relationAlias = null) Adds a RIGHT JOIN clause to the query using the RecruitmentUser relation
 * @method     RecruitmentDateQuery innerJoinRecruitmentUser($relationAlias = null) Adds a INNER JOIN clause to the query using the RecruitmentUser relation
 *
 * @method     RecruitmentDate findOne(PropelPDO $con = null) Return the first RecruitmentDate matching the query
 * @method     RecruitmentDate findOneOrCreate(PropelPDO $con = null) Return the first RecruitmentDate matching the query, or a new RecruitmentDate object populated from the query conditions when no match is found
 *
 * @method     RecruitmentDate findOneById(int $id) Return the first RecruitmentDate filtered by the id column
 * @method     RecruitmentDate findOneByRecruitmentId(int $recruitment_id) Return the first RecruitmentDate filtered by the recruitment_id column
 * @method     RecruitmentDate findOneByEventDateFrom(string $event_date_from) Return the first RecruitmentDate filtered by the event_date_from column
 * @method     RecruitmentDate findOneByEventDateTo(string $event_date_to) Return the first RecruitmentDate filtered by the event_date_to column
 * @method     RecruitmentDate findOneByNoActiveText(string $no_active_text) Return the first RecruitmentDate filtered by the no_active_text column
 * @method     RecruitmentDate findOneByUsedLimit(int $used_limit) Return the first RecruitmentDate filtered by the used_limit column
 * @method     RecruitmentDate findOneBySetLimit(int $set_limit) Return the first RecruitmentDate filtered by the set_limit column
 * @method     RecruitmentDate findOneByIsVisibleLimit(boolean $is_visible_limit) Return the first RecruitmentDate filtered by the is_visible_limit column
 * @method     RecruitmentDate findOneByIsNotSetEventDate(boolean $is_not_set_event_date) Return the first RecruitmentDate filtered by the is_not_set_event_date column
 * @method     RecruitmentDate findOneByIsActive(boolean $is_active) Return the first RecruitmentDate filtered by the is_active column
 * @method     RecruitmentDate findOneByIsAutomaticQualify(boolean $is_automatic_qualify) Return the first RecruitmentDate filtered by the is_automatic_qualify column
 * @method     RecruitmentDate findOneByCreatedAt(string $created_at) Return the first RecruitmentDate filtered by the created_at column
 * @method     RecruitmentDate findOneByUpdatedAt(string $updated_at) Return the first RecruitmentDate filtered by the updated_at column
 *
 * @method     array findById(int $id) Return RecruitmentDate objects filtered by the id column
 * @method     array findByRecruitmentId(int $recruitment_id) Return RecruitmentDate objects filtered by the recruitment_id column
 * @method     array findByEventDateFrom(string $event_date_from) Return RecruitmentDate objects filtered by the event_date_from column
 * @method     array findByEventDateTo(string $event_date_to) Return RecruitmentDate objects filtered by the event_date_to column
 * @method     array findByNoActiveText(string $no_active_text) Return RecruitmentDate objects filtered by the no_active_text column
 * @method     array findByUsedLimit(int $used_limit) Return RecruitmentDate objects filtered by the used_limit column
 * @method     array findBySetLimit(int $set_limit) Return RecruitmentDate objects filtered by the set_limit column
 * @method     array findByIsVisibleLimit(boolean $is_visible_limit) Return RecruitmentDate objects filtered by the is_visible_limit column
 * @method     array findByIsNotSetEventDate(boolean $is_not_set_event_date) Return RecruitmentDate objects filtered by the is_not_set_event_date column
 * @method     array findByIsActive(boolean $is_active) Return RecruitmentDate objects filtered by the is_active column
 * @method     array findByIsAutomaticQualify(boolean $is_automatic_qualify) Return RecruitmentDate objects filtered by the is_automatic_qualify column
 * @method     array findByCreatedAt(string $created_at) Return RecruitmentDate objects filtered by the created_at column
 * @method     array findByUpdatedAt(string $updated_at) Return RecruitmentDate objects filtered by the updated_at column
 *
 * @package    propel.generator.src.Visualnet.VisualRecruiter.RecruitmentBundle.Model.om
 */
abstract class BaseRecruitmentDateQuery extends ModelCriteria
{
	
	/**
	 * Initializes internal state of BaseRecruitmentDateQuery object.
	 *
	 * @param     string $dbName The dabase name
	 * @param     string $modelName The phpName of a model, e.g. 'Book'
	 * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
	 */
	public function __construct($dbName = 'default', $modelName = 'Visualnet\\VisualRecruiter\\RecruitmentBundle\\Model\\RecruitmentDate', $modelAlias = null)
	{
		parent::__construct($dbName, $modelName, $modelAlias);
	}

	/**
	 * Returns a new RecruitmentDateQuery object.
	 *
	 * @param     string $modelAlias The alias of a model in the query
	 * @param     Criteria $criteria Optional Criteria to build the query from
	 *
	 * @return    RecruitmentDateQuery
	 */
	public static function create($modelAlias = null, $criteria = null)
	{
		if ($criteria instanceof RecruitmentDateQuery) {
			return $criteria;
		}
		$query = new RecruitmentDateQuery();
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
	 * $obj  = $c->findPk(12, $con);
	 * </code>
	 *
	 * @param     mixed $key Primary key to use for the query
	 * @param     PropelPDO $con an optional connection object
	 *
	 * @return    RecruitmentDate|array|mixed the result, formatted by the current formatter
	 */
	public function findPk($key, $con = null)
	{
		if ($key === null) {
			return null;
		}
		if ((null !== ($obj = RecruitmentDatePeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
			// the object is alredy in the instance pool
			return $obj;
		}
		if ($con === null) {
			$con = Propel::getConnection(RecruitmentDatePeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
	 * @return    RecruitmentDate A model object, or null if the key is not found
	 */
	protected function findPkSimple($key, $con)
	{
		$sql = 'SELECT `ID`, `RECRUITMENT_ID`, `EVENT_DATE_FROM`, `EVENT_DATE_TO`, `NO_ACTIVE_TEXT`, `USED_LIMIT`, `SET_LIMIT`, `IS_VISIBLE_LIMIT`, `IS_NOT_SET_EVENT_DATE`, `IS_ACTIVE`, `IS_AUTOMATIC_QUALIFY`, `CREATED_AT`, `UPDATED_AT` FROM `visual_recruitment_date` WHERE `ID` = :p0';
		try {
			$stmt = $con->prepare($sql);			
			$stmt->bindValue(':p0', $key, PDO::PARAM_INT);
			$stmt->execute();
		} catch (Exception $e) {
			Propel::log($e->getMessage(), Propel::LOG_ERR);
			throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), $e);
		}
		$obj = null;
		if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$obj = new RecruitmentDate();
			$obj->hydrate($row);
			RecruitmentDatePeer::addInstanceToPool($obj, (string) $key);
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
	 * @return    RecruitmentDate|array|mixed the result, formatted by the current formatter
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
	 * $objs = $c->findPks(array(12, 56, 832), $con);
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
	 * @return    RecruitmentDateQuery The current query, for fluid interface
	 */
	public function filterByPrimaryKey($key)
	{
		return $this->addUsingAlias(RecruitmentDatePeer::ID, $key, Criteria::EQUAL);
	}

	/**
	 * Filter the query by a list of primary keys
	 *
	 * @param     array $keys The list of primary key to use for the query
	 *
	 * @return    RecruitmentDateQuery The current query, for fluid interface
	 */
	public function filterByPrimaryKeys($keys)
	{
		return $this->addUsingAlias(RecruitmentDatePeer::ID, $keys, Criteria::IN);
	}

	/**
	 * Filter the query on the id column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterById(1234); // WHERE id = 1234
	 * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
	 * $query->filterById(array('min' => 12)); // WHERE id > 12
	 * </code>
	 *
	 * @param     mixed $id The value to use as filter.
	 *              Use scalar values for equality.
	 *              Use array values for in_array() equivalent.
	 *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    RecruitmentDateQuery The current query, for fluid interface
	 */
	public function filterById($id = null, $comparison = null)
	{
		if (is_array($id) && null === $comparison) {
			$comparison = Criteria::IN;
		}
		return $this->addUsingAlias(RecruitmentDatePeer::ID, $id, $comparison);
	}

	/**
	 * Filter the query on the recruitment_id column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByRecruitmentId(1234); // WHERE recruitment_id = 1234
	 * $query->filterByRecruitmentId(array(12, 34)); // WHERE recruitment_id IN (12, 34)
	 * $query->filterByRecruitmentId(array('min' => 12)); // WHERE recruitment_id > 12
	 * </code>
	 *
	 * @see       filterByRecruitment()
	 *
	 * @param     mixed $recruitmentId The value to use as filter.
	 *              Use scalar values for equality.
	 *              Use array values for in_array() equivalent.
	 *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    RecruitmentDateQuery The current query, for fluid interface
	 */
	public function filterByRecruitmentId($recruitmentId = null, $comparison = null)
	{
		if (is_array($recruitmentId)) {
			$useMinMax = false;
			if (isset($recruitmentId['min'])) {
				$this->addUsingAlias(RecruitmentDatePeer::RECRUITMENT_ID, $recruitmentId['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($recruitmentId['max'])) {
				$this->addUsingAlias(RecruitmentDatePeer::RECRUITMENT_ID, $recruitmentId['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(RecruitmentDatePeer::RECRUITMENT_ID, $recruitmentId, $comparison);
	}

	/**
	 * Filter the query on the event_date_from column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByEventDateFrom('2011-03-14'); // WHERE event_date_from = '2011-03-14'
	 * $query->filterByEventDateFrom('now'); // WHERE event_date_from = '2011-03-14'
	 * $query->filterByEventDateFrom(array('max' => 'yesterday')); // WHERE event_date_from > '2011-03-13'
	 * </code>
	 *
	 * @param     mixed $eventDateFrom The value to use as filter.
	 *              Values can be integers (unix timestamps), DateTime objects, or strings.
	 *              Empty strings are treated as NULL.
	 *              Use scalar values for equality.
	 *              Use array values for in_array() equivalent.
	 *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    RecruitmentDateQuery The current query, for fluid interface
	 */
	public function filterByEventDateFrom($eventDateFrom = null, $comparison = null)
	{
		if (is_array($eventDateFrom)) {
			$useMinMax = false;
			if (isset($eventDateFrom['min'])) {
				$this->addUsingAlias(RecruitmentDatePeer::EVENT_DATE_FROM, $eventDateFrom['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($eventDateFrom['max'])) {
				$this->addUsingAlias(RecruitmentDatePeer::EVENT_DATE_FROM, $eventDateFrom['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(RecruitmentDatePeer::EVENT_DATE_FROM, $eventDateFrom, $comparison);
	}

	/**
	 * Filter the query on the event_date_to column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByEventDateTo('2011-03-14'); // WHERE event_date_to = '2011-03-14'
	 * $query->filterByEventDateTo('now'); // WHERE event_date_to = '2011-03-14'
	 * $query->filterByEventDateTo(array('max' => 'yesterday')); // WHERE event_date_to > '2011-03-13'
	 * </code>
	 *
	 * @param     mixed $eventDateTo The value to use as filter.
	 *              Values can be integers (unix timestamps), DateTime objects, or strings.
	 *              Empty strings are treated as NULL.
	 *              Use scalar values for equality.
	 *              Use array values for in_array() equivalent.
	 *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    RecruitmentDateQuery The current query, for fluid interface
	 */
	public function filterByEventDateTo($eventDateTo = null, $comparison = null)
	{
		if (is_array($eventDateTo)) {
			$useMinMax = false;
			if (isset($eventDateTo['min'])) {
				$this->addUsingAlias(RecruitmentDatePeer::EVENT_DATE_TO, $eventDateTo['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($eventDateTo['max'])) {
				$this->addUsingAlias(RecruitmentDatePeer::EVENT_DATE_TO, $eventDateTo['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(RecruitmentDatePeer::EVENT_DATE_TO, $eventDateTo, $comparison);
	}

	/**
	 * Filter the query on the no_active_text column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByNoActiveText('fooValue');   // WHERE no_active_text = 'fooValue'
	 * $query->filterByNoActiveText('%fooValue%'); // WHERE no_active_text LIKE '%fooValue%'
	 * </code>
	 *
	 * @param     string $noActiveText The value to use as filter.
	 *              Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    RecruitmentDateQuery The current query, for fluid interface
	 */
	public function filterByNoActiveText($noActiveText = null, $comparison = null)
	{
		if (null === $comparison) {
			if (is_array($noActiveText)) {
				$comparison = Criteria::IN;
			} elseif (preg_match('/[\%\*]/', $noActiveText)) {
				$noActiveText = str_replace('*', '%', $noActiveText);
				$comparison = Criteria::LIKE;
			}
		}
		return $this->addUsingAlias(RecruitmentDatePeer::NO_ACTIVE_TEXT, $noActiveText, $comparison);
	}

	/**
	 * Filter the query on the used_limit column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByUsedLimit(1234); // WHERE used_limit = 1234
	 * $query->filterByUsedLimit(array(12, 34)); // WHERE used_limit IN (12, 34)
	 * $query->filterByUsedLimit(array('min' => 12)); // WHERE used_limit > 12
	 * </code>
	 *
	 * @param     mixed $usedLimit The value to use as filter.
	 *              Use scalar values for equality.
	 *              Use array values for in_array() equivalent.
	 *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    RecruitmentDateQuery The current query, for fluid interface
	 */
	public function filterByUsedLimit($usedLimit = null, $comparison = null)
	{
		if (is_array($usedLimit)) {
			$useMinMax = false;
			if (isset($usedLimit['min'])) {
				$this->addUsingAlias(RecruitmentDatePeer::USED_LIMIT, $usedLimit['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($usedLimit['max'])) {
				$this->addUsingAlias(RecruitmentDatePeer::USED_LIMIT, $usedLimit['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(RecruitmentDatePeer::USED_LIMIT, $usedLimit, $comparison);
	}

	/**
	 * Filter the query on the set_limit column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterBySetLimit(1234); // WHERE set_limit = 1234
	 * $query->filterBySetLimit(array(12, 34)); // WHERE set_limit IN (12, 34)
	 * $query->filterBySetLimit(array('min' => 12)); // WHERE set_limit > 12
	 * </code>
	 *
	 * @param     mixed $setLimit The value to use as filter.
	 *              Use scalar values for equality.
	 *              Use array values for in_array() equivalent.
	 *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    RecruitmentDateQuery The current query, for fluid interface
	 */
	public function filterBySetLimit($setLimit = null, $comparison = null)
	{
		if (is_array($setLimit)) {
			$useMinMax = false;
			if (isset($setLimit['min'])) {
				$this->addUsingAlias(RecruitmentDatePeer::SET_LIMIT, $setLimit['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($setLimit['max'])) {
				$this->addUsingAlias(RecruitmentDatePeer::SET_LIMIT, $setLimit['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(RecruitmentDatePeer::SET_LIMIT, $setLimit, $comparison);
	}

	/**
	 * Filter the query on the is_visible_limit column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByIsVisibleLimit(true); // WHERE is_visible_limit = true
	 * $query->filterByIsVisibleLimit('yes'); // WHERE is_visible_limit = true
	 * </code>
	 *
	 * @param     boolean|string $isVisibleLimit The value to use as filter.
	 *              Non-boolean arguments are converted using the following rules:
	 *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
	 *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
	 *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    RecruitmentDateQuery The current query, for fluid interface
	 */
	public function filterByIsVisibleLimit($isVisibleLimit = null, $comparison = null)
	{
		if (is_string($isVisibleLimit)) {
			$is_visible_limit = in_array(strtolower($isVisibleLimit), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
		}
		return $this->addUsingAlias(RecruitmentDatePeer::IS_VISIBLE_LIMIT, $isVisibleLimit, $comparison);
	}

	/**
	 * Filter the query on the is_not_set_event_date column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByIsNotSetEventDate(true); // WHERE is_not_set_event_date = true
	 * $query->filterByIsNotSetEventDate('yes'); // WHERE is_not_set_event_date = true
	 * </code>
	 *
	 * @param     boolean|string $isNotSetEventDate The value to use as filter.
	 *              Non-boolean arguments are converted using the following rules:
	 *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
	 *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
	 *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    RecruitmentDateQuery The current query, for fluid interface
	 */
	public function filterByIsNotSetEventDate($isNotSetEventDate = null, $comparison = null)
	{
		if (is_string($isNotSetEventDate)) {
			$is_not_set_event_date = in_array(strtolower($isNotSetEventDate), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
		}
		return $this->addUsingAlias(RecruitmentDatePeer::IS_NOT_SET_EVENT_DATE, $isNotSetEventDate, $comparison);
	}

	/**
	 * Filter the query on the is_active column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByIsActive(true); // WHERE is_active = true
	 * $query->filterByIsActive('yes'); // WHERE is_active = true
	 * </code>
	 *
	 * @param     boolean|string $isActive The value to use as filter.
	 *              Non-boolean arguments are converted using the following rules:
	 *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
	 *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
	 *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    RecruitmentDateQuery The current query, for fluid interface
	 */
	public function filterByIsActive($isActive = null, $comparison = null)
	{
		if (is_string($isActive)) {
			$is_active = in_array(strtolower($isActive), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
		}
		return $this->addUsingAlias(RecruitmentDatePeer::IS_ACTIVE, $isActive, $comparison);
	}

	/**
	 * Filter the query on the is_automatic_qualify column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByIsAutomaticQualify(true); // WHERE is_automatic_qualify = true
	 * $query->filterByIsAutomaticQualify('yes'); // WHERE is_automatic_qualify = true
	 * </code>
	 *
	 * @param     boolean|string $isAutomaticQualify The value to use as filter.
	 *              Non-boolean arguments are converted using the following rules:
	 *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
	 *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
	 *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    RecruitmentDateQuery The current query, for fluid interface
	 */
	public function filterByIsAutomaticQualify($isAutomaticQualify = null, $comparison = null)
	{
		if (is_string($isAutomaticQualify)) {
			$is_automatic_qualify = in_array(strtolower($isAutomaticQualify), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
		}
		return $this->addUsingAlias(RecruitmentDatePeer::IS_AUTOMATIC_QUALIFY, $isAutomaticQualify, $comparison);
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
	 * @return    RecruitmentDateQuery The current query, for fluid interface
	 */
	public function filterByCreatedAt($createdAt = null, $comparison = null)
	{
		if (is_array($createdAt)) {
			$useMinMax = false;
			if (isset($createdAt['min'])) {
				$this->addUsingAlias(RecruitmentDatePeer::CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($createdAt['max'])) {
				$this->addUsingAlias(RecruitmentDatePeer::CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(RecruitmentDatePeer::CREATED_AT, $createdAt, $comparison);
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
	 * @return    RecruitmentDateQuery The current query, for fluid interface
	 */
	public function filterByUpdatedAt($updatedAt = null, $comparison = null)
	{
		if (is_array($updatedAt)) {
			$useMinMax = false;
			if (isset($updatedAt['min'])) {
				$this->addUsingAlias(RecruitmentDatePeer::UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($updatedAt['max'])) {
				$this->addUsingAlias(RecruitmentDatePeer::UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(RecruitmentDatePeer::UPDATED_AT, $updatedAt, $comparison);
	}

	/**
	 * Filter the query by a related Recruitment object
	 *
	 * @param     Recruitment|PropelCollection $recruitment The related object(s) to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    RecruitmentDateQuery The current query, for fluid interface
	 */
	public function filterByRecruitment($recruitment, $comparison = null)
	{
		if ($recruitment instanceof Recruitment) {
			return $this
				->addUsingAlias(RecruitmentDatePeer::RECRUITMENT_ID, $recruitment->getId(), $comparison);
		} elseif ($recruitment instanceof PropelCollection) {
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
			return $this
				->addUsingAlias(RecruitmentDatePeer::RECRUITMENT_ID, $recruitment->toKeyValue('PrimaryKey', 'Id'), $comparison);
		} else {
			throw new PropelException('filterByRecruitment() only accepts arguments of type Recruitment or PropelCollection');
		}
	}

	/**
	 * Adds a JOIN clause to the query using the Recruitment relation
	 *
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    RecruitmentDateQuery The current query, for fluid interface
	 */
	public function joinRecruitment($relationAlias = null, $joinType = Criteria::INNER_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('Recruitment');

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
			$this->addJoinObject($join, 'Recruitment');
		}

		return $this;
	}

	/**
	 * Use the Recruitment relation Recruitment object
	 *
	 * @see       useQuery()
	 *
	 * @param     string $relationAlias optional alias for the relation,
	 *                                   to be used as main alias in the secondary query
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    \Visualnet\VisualRecruiter\RecruitmentBundle\Model\RecruitmentQuery A secondary query class using the current class as primary query
	 */
	public function useRecruitmentQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
	{
		return $this
			->joinRecruitment($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'Recruitment', '\Visualnet\VisualRecruiter\RecruitmentBundle\Model\RecruitmentQuery');
	}

	/**
	 * Filter the query by a related RecruitmentUser object
	 *
	 * @param     RecruitmentUser $recruitmentUser  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    RecruitmentDateQuery The current query, for fluid interface
	 */
	public function filterByRecruitmentUser($recruitmentUser, $comparison = null)
	{
		if ($recruitmentUser instanceof RecruitmentUser) {
			return $this
				->addUsingAlias(RecruitmentDatePeer::ID, $recruitmentUser->getRecruitmentDateId(), $comparison);
		} elseif ($recruitmentUser instanceof PropelCollection) {
			return $this
				->useRecruitmentUserQuery()
				->filterByPrimaryKeys($recruitmentUser->getPrimaryKeys())
				->endUse();
		} else {
			throw new PropelException('filterByRecruitmentUser() only accepts arguments of type RecruitmentUser or PropelCollection');
		}
	}

	/**
	 * Adds a JOIN clause to the query using the RecruitmentUser relation
	 *
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    RecruitmentDateQuery The current query, for fluid interface
	 */
	public function joinRecruitmentUser($relationAlias = null, $joinType = Criteria::INNER_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('RecruitmentUser');

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
			$this->addJoinObject($join, 'RecruitmentUser');
		}

		return $this;
	}

	/**
	 * Use the RecruitmentUser relation RecruitmentUser object
	 *
	 * @see       useQuery()
	 *
	 * @param     string $relationAlias optional alias for the relation,
	 *                                   to be used as main alias in the secondary query
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    \Visualnet\VisualRecruiter\RecruitmentBundle\Model\RecruitmentUserQuery A secondary query class using the current class as primary query
	 */
	public function useRecruitmentUserQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
	{
		return $this
			->joinRecruitmentUser($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'RecruitmentUser', '\Visualnet\VisualRecruiter\RecruitmentBundle\Model\RecruitmentUserQuery');
	}

	/**
	 * Exclude object from result
	 *
	 * @param     RecruitmentDate $recruitmentDate Object to remove from the list of results
	 *
	 * @return    RecruitmentDateQuery The current query, for fluid interface
	 */
	public function prune($recruitmentDate = null)
	{
		if ($recruitmentDate) {
			$this->addUsingAlias(RecruitmentDatePeer::ID, $recruitmentDate->getId(), Criteria::NOT_EQUAL);
		}

		return $this;
	}

	// timestampable behavior
	
	/**
	 * Filter by the latest updated
	 *
	 * @param      int $nbDays Maximum age of the latest update in days
	 *
	 * @return     RecruitmentDateQuery The current query, for fluid interface
	 */
	public function recentlyUpdated($nbDays = 7)
	{
		return $this->addUsingAlias(RecruitmentDatePeer::UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
	}
	
	/**
	 * Filter by the latest created
	 *
	 * @param      int $nbDays Maximum age of in days
	 *
	 * @return     RecruitmentDateQuery The current query, for fluid interface
	 */
	public function recentlyCreated($nbDays = 7)
	{
		return $this->addUsingAlias(RecruitmentDatePeer::CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
	}
	
	/**
	 * Order by update date desc
	 *
	 * @return     RecruitmentDateQuery The current query, for fluid interface
	 */
	public function lastUpdatedFirst()
	{
		return $this->addDescendingOrderByColumn(RecruitmentDatePeer::UPDATED_AT);
	}
	
	/**
	 * Order by update date asc
	 *
	 * @return     RecruitmentDateQuery The current query, for fluid interface
	 */
	public function firstUpdatedFirst()
	{
		return $this->addAscendingOrderByColumn(RecruitmentDatePeer::UPDATED_AT);
	}
	
	/**
	 * Order by create date desc
	 *
	 * @return     RecruitmentDateQuery The current query, for fluid interface
	 */
	public function lastCreatedFirst()
	{
		return $this->addDescendingOrderByColumn(RecruitmentDatePeer::CREATED_AT);
	}
	
	/**
	 * Order by create date asc
	 *
	 * @return     RecruitmentDateQuery The current query, for fluid interface
	 */
	public function firstCreatedFirst()
	{
		return $this->addAscendingOrderByColumn(RecruitmentDatePeer::CREATED_AT);
	}

} // BaseRecruitmentDateQuery