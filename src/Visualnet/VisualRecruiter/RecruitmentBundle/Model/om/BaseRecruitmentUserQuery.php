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
use Visualnet\VisualRecruiter\RecruitmentBundle\Model\RecruitmentUser;
use Visualnet\VisualRecruiter\RecruitmentBundle\Model\RecruitmentUserData;
use Visualnet\VisualRecruiter\RecruitmentBundle\Model\RecruitmentUserPeer;
use Visualnet\VisualRecruiter\RecruitmentBundle\Model\RecruitmentUserQuery;

/**
 * Base class that represents a query for the 'visual_recruitment_user' table.
 *
 * 
 *
 * @method     RecruitmentUserQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     RecruitmentUserQuery orderByRecruitmentId($order = Criteria::ASC) Order by the recruitment_id column
 * @method     RecruitmentUserQuery orderByRecruitmentDateId($order = Criteria::ASC) Order by the recruitment_date_id column
 * @method     RecruitmentUserQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method     RecruitmentUserQuery orderBySurname($order = Criteria::ASC) Order by the surname column
 * @method     RecruitmentUserQuery orderByEmail($order = Criteria::ASC) Order by the email column
 * @method     RecruitmentUserQuery orderByIsQualify($order = Criteria::ASC) Order by the is_qualify column
 * @method     RecruitmentUserQuery orderByIsActive($order = Criteria::ASC) Order by the is_active column
 * @method     RecruitmentUserQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     RecruitmentUserQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method     RecruitmentUserQuery groupById() Group by the id column
 * @method     RecruitmentUserQuery groupByRecruitmentId() Group by the recruitment_id column
 * @method     RecruitmentUserQuery groupByRecruitmentDateId() Group by the recruitment_date_id column
 * @method     RecruitmentUserQuery groupByName() Group by the name column
 * @method     RecruitmentUserQuery groupBySurname() Group by the surname column
 * @method     RecruitmentUserQuery groupByEmail() Group by the email column
 * @method     RecruitmentUserQuery groupByIsQualify() Group by the is_qualify column
 * @method     RecruitmentUserQuery groupByIsActive() Group by the is_active column
 * @method     RecruitmentUserQuery groupByCreatedAt() Group by the created_at column
 * @method     RecruitmentUserQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method     RecruitmentUserQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     RecruitmentUserQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     RecruitmentUserQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     RecruitmentUserQuery leftJoinRecruitment($relationAlias = null) Adds a LEFT JOIN clause to the query using the Recruitment relation
 * @method     RecruitmentUserQuery rightJoinRecruitment($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Recruitment relation
 * @method     RecruitmentUserQuery innerJoinRecruitment($relationAlias = null) Adds a INNER JOIN clause to the query using the Recruitment relation
 *
 * @method     RecruitmentUserQuery leftJoinRecruitmentDate($relationAlias = null) Adds a LEFT JOIN clause to the query using the RecruitmentDate relation
 * @method     RecruitmentUserQuery rightJoinRecruitmentDate($relationAlias = null) Adds a RIGHT JOIN clause to the query using the RecruitmentDate relation
 * @method     RecruitmentUserQuery innerJoinRecruitmentDate($relationAlias = null) Adds a INNER JOIN clause to the query using the RecruitmentDate relation
 *
 * @method     RecruitmentUserQuery leftJoinRecruitmentUserData($relationAlias = null) Adds a LEFT JOIN clause to the query using the RecruitmentUserData relation
 * @method     RecruitmentUserQuery rightJoinRecruitmentUserData($relationAlias = null) Adds a RIGHT JOIN clause to the query using the RecruitmentUserData relation
 * @method     RecruitmentUserQuery innerJoinRecruitmentUserData($relationAlias = null) Adds a INNER JOIN clause to the query using the RecruitmentUserData relation
 *
 * @method     RecruitmentUser findOne(PropelPDO $con = null) Return the first RecruitmentUser matching the query
 * @method     RecruitmentUser findOneOrCreate(PropelPDO $con = null) Return the first RecruitmentUser matching the query, or a new RecruitmentUser object populated from the query conditions when no match is found
 *
 * @method     RecruitmentUser findOneById(int $id) Return the first RecruitmentUser filtered by the id column
 * @method     RecruitmentUser findOneByRecruitmentId(int $recruitment_id) Return the first RecruitmentUser filtered by the recruitment_id column
 * @method     RecruitmentUser findOneByRecruitmentDateId(int $recruitment_date_id) Return the first RecruitmentUser filtered by the recruitment_date_id column
 * @method     RecruitmentUser findOneByName(string $name) Return the first RecruitmentUser filtered by the name column
 * @method     RecruitmentUser findOneBySurname(string $surname) Return the first RecruitmentUser filtered by the surname column
 * @method     RecruitmentUser findOneByEmail(string $email) Return the first RecruitmentUser filtered by the email column
 * @method     RecruitmentUser findOneByIsQualify(boolean $is_qualify) Return the first RecruitmentUser filtered by the is_qualify column
 * @method     RecruitmentUser findOneByIsActive(boolean $is_active) Return the first RecruitmentUser filtered by the is_active column
 * @method     RecruitmentUser findOneByCreatedAt(string $created_at) Return the first RecruitmentUser filtered by the created_at column
 * @method     RecruitmentUser findOneByUpdatedAt(string $updated_at) Return the first RecruitmentUser filtered by the updated_at column
 *
 * @method     array findById(int $id) Return RecruitmentUser objects filtered by the id column
 * @method     array findByRecruitmentId(int $recruitment_id) Return RecruitmentUser objects filtered by the recruitment_id column
 * @method     array findByRecruitmentDateId(int $recruitment_date_id) Return RecruitmentUser objects filtered by the recruitment_date_id column
 * @method     array findByName(string $name) Return RecruitmentUser objects filtered by the name column
 * @method     array findBySurname(string $surname) Return RecruitmentUser objects filtered by the surname column
 * @method     array findByEmail(string $email) Return RecruitmentUser objects filtered by the email column
 * @method     array findByIsQualify(boolean $is_qualify) Return RecruitmentUser objects filtered by the is_qualify column
 * @method     array findByIsActive(boolean $is_active) Return RecruitmentUser objects filtered by the is_active column
 * @method     array findByCreatedAt(string $created_at) Return RecruitmentUser objects filtered by the created_at column
 * @method     array findByUpdatedAt(string $updated_at) Return RecruitmentUser objects filtered by the updated_at column
 *
 * @package    propel.generator.src.Visualnet.VisualRecruiter.RecruitmentBundle.Model.om
 */
abstract class BaseRecruitmentUserQuery extends ModelCriteria
{
	
	/**
	 * Initializes internal state of BaseRecruitmentUserQuery object.
	 *
	 * @param     string $dbName The dabase name
	 * @param     string $modelName The phpName of a model, e.g. 'Book'
	 * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
	 */
	public function __construct($dbName = 'default', $modelName = 'Visualnet\\VisualRecruiter\\RecruitmentBundle\\Model\\RecruitmentUser', $modelAlias = null)
	{
		parent::__construct($dbName, $modelName, $modelAlias);
	}

	/**
	 * Returns a new RecruitmentUserQuery object.
	 *
	 * @param     string $modelAlias The alias of a model in the query
	 * @param     Criteria $criteria Optional Criteria to build the query from
	 *
	 * @return    RecruitmentUserQuery
	 */
	public static function create($modelAlias = null, $criteria = null)
	{
		if ($criteria instanceof RecruitmentUserQuery) {
			return $criteria;
		}
		$query = new RecruitmentUserQuery();
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
	 * @return    RecruitmentUser|array|mixed the result, formatted by the current formatter
	 */
	public function findPk($key, $con = null)
	{
		if ($key === null) {
			return null;
		}
		if ((null !== ($obj = RecruitmentUserPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
			// the object is alredy in the instance pool
			return $obj;
		}
		if ($con === null) {
			$con = Propel::getConnection(RecruitmentUserPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
	 * @return    RecruitmentUser A model object, or null if the key is not found
	 */
	protected function findPkSimple($key, $con)
	{
		$sql = 'SELECT `ID`, `RECRUITMENT_ID`, `RECRUITMENT_DATE_ID`, `NAME`, `SURNAME`, `EMAIL`, `IS_QUALIFY`, `IS_ACTIVE`, `CREATED_AT`, `UPDATED_AT` FROM `visual_recruitment_user` WHERE `ID` = :p0';
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
			$obj = new RecruitmentUser();
			$obj->hydrate($row);
			RecruitmentUserPeer::addInstanceToPool($obj, (string) $key);
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
	 * @return    RecruitmentUser|array|mixed the result, formatted by the current formatter
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
	 * @return    RecruitmentUserQuery The current query, for fluid interface
	 */
	public function filterByPrimaryKey($key)
	{
		return $this->addUsingAlias(RecruitmentUserPeer::ID, $key, Criteria::EQUAL);
	}

	/**
	 * Filter the query by a list of primary keys
	 *
	 * @param     array $keys The list of primary key to use for the query
	 *
	 * @return    RecruitmentUserQuery The current query, for fluid interface
	 */
	public function filterByPrimaryKeys($keys)
	{
		return $this->addUsingAlias(RecruitmentUserPeer::ID, $keys, Criteria::IN);
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
	 * @return    RecruitmentUserQuery The current query, for fluid interface
	 */
	public function filterById($id = null, $comparison = null)
	{
		if (is_array($id) && null === $comparison) {
			$comparison = Criteria::IN;
		}
		return $this->addUsingAlias(RecruitmentUserPeer::ID, $id, $comparison);
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
	 * @return    RecruitmentUserQuery The current query, for fluid interface
	 */
	public function filterByRecruitmentId($recruitmentId = null, $comparison = null)
	{
		if (is_array($recruitmentId)) {
			$useMinMax = false;
			if (isset($recruitmentId['min'])) {
				$this->addUsingAlias(RecruitmentUserPeer::RECRUITMENT_ID, $recruitmentId['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($recruitmentId['max'])) {
				$this->addUsingAlias(RecruitmentUserPeer::RECRUITMENT_ID, $recruitmentId['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(RecruitmentUserPeer::RECRUITMENT_ID, $recruitmentId, $comparison);
	}

	/**
	 * Filter the query on the recruitment_date_id column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByRecruitmentDateId(1234); // WHERE recruitment_date_id = 1234
	 * $query->filterByRecruitmentDateId(array(12, 34)); // WHERE recruitment_date_id IN (12, 34)
	 * $query->filterByRecruitmentDateId(array('min' => 12)); // WHERE recruitment_date_id > 12
	 * </code>
	 *
	 * @see       filterByRecruitmentDate()
	 *
	 * @param     mixed $recruitmentDateId The value to use as filter.
	 *              Use scalar values for equality.
	 *              Use array values for in_array() equivalent.
	 *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    RecruitmentUserQuery The current query, for fluid interface
	 */
	public function filterByRecruitmentDateId($recruitmentDateId = null, $comparison = null)
	{
		if (is_array($recruitmentDateId)) {
			$useMinMax = false;
			if (isset($recruitmentDateId['min'])) {
				$this->addUsingAlias(RecruitmentUserPeer::RECRUITMENT_DATE_ID, $recruitmentDateId['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($recruitmentDateId['max'])) {
				$this->addUsingAlias(RecruitmentUserPeer::RECRUITMENT_DATE_ID, $recruitmentDateId['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(RecruitmentUserPeer::RECRUITMENT_DATE_ID, $recruitmentDateId, $comparison);
	}

	/**
	 * Filter the query on the name column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByName('fooValue');   // WHERE name = 'fooValue'
	 * $query->filterByName('%fooValue%'); // WHERE name LIKE '%fooValue%'
	 * </code>
	 *
	 * @param     string $name The value to use as filter.
	 *              Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    RecruitmentUserQuery The current query, for fluid interface
	 */
	public function filterByName($name = null, $comparison = null)
	{
		if (null === $comparison) {
			if (is_array($name)) {
				$comparison = Criteria::IN;
			} elseif (preg_match('/[\%\*]/', $name)) {
				$name = str_replace('*', '%', $name);
				$comparison = Criteria::LIKE;
			}
		}
		return $this->addUsingAlias(RecruitmentUserPeer::NAME, $name, $comparison);
	}

	/**
	 * Filter the query on the surname column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterBySurname('fooValue');   // WHERE surname = 'fooValue'
	 * $query->filterBySurname('%fooValue%'); // WHERE surname LIKE '%fooValue%'
	 * </code>
	 *
	 * @param     string $surname The value to use as filter.
	 *              Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    RecruitmentUserQuery The current query, for fluid interface
	 */
	public function filterBySurname($surname = null, $comparison = null)
	{
		if (null === $comparison) {
			if (is_array($surname)) {
				$comparison = Criteria::IN;
			} elseif (preg_match('/[\%\*]/', $surname)) {
				$surname = str_replace('*', '%', $surname);
				$comparison = Criteria::LIKE;
			}
		}
		return $this->addUsingAlias(RecruitmentUserPeer::SURNAME, $surname, $comparison);
	}

	/**
	 * Filter the query on the email column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByEmail('fooValue');   // WHERE email = 'fooValue'
	 * $query->filterByEmail('%fooValue%'); // WHERE email LIKE '%fooValue%'
	 * </code>
	 *
	 * @param     string $email The value to use as filter.
	 *              Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    RecruitmentUserQuery The current query, for fluid interface
	 */
	public function filterByEmail($email = null, $comparison = null)
	{
		if (null === $comparison) {
			if (is_array($email)) {
				$comparison = Criteria::IN;
			} elseif (preg_match('/[\%\*]/', $email)) {
				$email = str_replace('*', '%', $email);
				$comparison = Criteria::LIKE;
			}
		}
		return $this->addUsingAlias(RecruitmentUserPeer::EMAIL, $email, $comparison);
	}

	/**
	 * Filter the query on the is_qualify column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByIsQualify(true); // WHERE is_qualify = true
	 * $query->filterByIsQualify('yes'); // WHERE is_qualify = true
	 * </code>
	 *
	 * @param     boolean|string $isQualify The value to use as filter.
	 *              Non-boolean arguments are converted using the following rules:
	 *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
	 *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
	 *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    RecruitmentUserQuery The current query, for fluid interface
	 */
	public function filterByIsQualify($isQualify = null, $comparison = null)
	{
		if (is_string($isQualify)) {
			$is_qualify = in_array(strtolower($isQualify), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
		}
		return $this->addUsingAlias(RecruitmentUserPeer::IS_QUALIFY, $isQualify, $comparison);
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
	 * @return    RecruitmentUserQuery The current query, for fluid interface
	 */
	public function filterByIsActive($isActive = null, $comparison = null)
	{
		if (is_string($isActive)) {
			$is_active = in_array(strtolower($isActive), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
		}
		return $this->addUsingAlias(RecruitmentUserPeer::IS_ACTIVE, $isActive, $comparison);
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
	 * @return    RecruitmentUserQuery The current query, for fluid interface
	 */
	public function filterByCreatedAt($createdAt = null, $comparison = null)
	{
		if (is_array($createdAt)) {
			$useMinMax = false;
			if (isset($createdAt['min'])) {
				$this->addUsingAlias(RecruitmentUserPeer::CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($createdAt['max'])) {
				$this->addUsingAlias(RecruitmentUserPeer::CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(RecruitmentUserPeer::CREATED_AT, $createdAt, $comparison);
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
	 * @return    RecruitmentUserQuery The current query, for fluid interface
	 */
	public function filterByUpdatedAt($updatedAt = null, $comparison = null)
	{
		if (is_array($updatedAt)) {
			$useMinMax = false;
			if (isset($updatedAt['min'])) {
				$this->addUsingAlias(RecruitmentUserPeer::UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($updatedAt['max'])) {
				$this->addUsingAlias(RecruitmentUserPeer::UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(RecruitmentUserPeer::UPDATED_AT, $updatedAt, $comparison);
	}

	/**
	 * Filter the query by a related Recruitment object
	 *
	 * @param     Recruitment|PropelCollection $recruitment The related object(s) to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    RecruitmentUserQuery The current query, for fluid interface
	 */
	public function filterByRecruitment($recruitment, $comparison = null)
	{
		if ($recruitment instanceof Recruitment) {
			return $this
				->addUsingAlias(RecruitmentUserPeer::RECRUITMENT_ID, $recruitment->getId(), $comparison);
		} elseif ($recruitment instanceof PropelCollection) {
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
			return $this
				->addUsingAlias(RecruitmentUserPeer::RECRUITMENT_ID, $recruitment->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
	 * @return    RecruitmentUserQuery The current query, for fluid interface
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
	 * Filter the query by a related RecruitmentDate object
	 *
	 * @param     RecruitmentDate|PropelCollection $recruitmentDate The related object(s) to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    RecruitmentUserQuery The current query, for fluid interface
	 */
	public function filterByRecruitmentDate($recruitmentDate, $comparison = null)
	{
		if ($recruitmentDate instanceof RecruitmentDate) {
			return $this
				->addUsingAlias(RecruitmentUserPeer::RECRUITMENT_DATE_ID, $recruitmentDate->getId(), $comparison);
		} elseif ($recruitmentDate instanceof PropelCollection) {
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
			return $this
				->addUsingAlias(RecruitmentUserPeer::RECRUITMENT_DATE_ID, $recruitmentDate->toKeyValue('PrimaryKey', 'Id'), $comparison);
		} else {
			throw new PropelException('filterByRecruitmentDate() only accepts arguments of type RecruitmentDate or PropelCollection');
		}
	}

	/**
	 * Adds a JOIN clause to the query using the RecruitmentDate relation
	 *
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    RecruitmentUserQuery The current query, for fluid interface
	 */
	public function joinRecruitmentDate($relationAlias = null, $joinType = Criteria::INNER_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('RecruitmentDate');

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
			$this->addJoinObject($join, 'RecruitmentDate');
		}

		return $this;
	}

	/**
	 * Use the RecruitmentDate relation RecruitmentDate object
	 *
	 * @see       useQuery()
	 *
	 * @param     string $relationAlias optional alias for the relation,
	 *                                   to be used as main alias in the secondary query
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    \Visualnet\VisualRecruiter\RecruitmentBundle\Model\RecruitmentDateQuery A secondary query class using the current class as primary query
	 */
	public function useRecruitmentDateQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
	{
		return $this
			->joinRecruitmentDate($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'RecruitmentDate', '\Visualnet\VisualRecruiter\RecruitmentBundle\Model\RecruitmentDateQuery');
	}

	/**
	 * Filter the query by a related RecruitmentUserData object
	 *
	 * @param     RecruitmentUserData $recruitmentUserData  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    RecruitmentUserQuery The current query, for fluid interface
	 */
	public function filterByRecruitmentUserData($recruitmentUserData, $comparison = null)
	{
		if ($recruitmentUserData instanceof RecruitmentUserData) {
			return $this
				->addUsingAlias(RecruitmentUserPeer::ID, $recruitmentUserData->getUserRecruitmentId(), $comparison);
		} elseif ($recruitmentUserData instanceof PropelCollection) {
			return $this
				->useRecruitmentUserDataQuery()
				->filterByPrimaryKeys($recruitmentUserData->getPrimaryKeys())
				->endUse();
		} else {
			throw new PropelException('filterByRecruitmentUserData() only accepts arguments of type RecruitmentUserData or PropelCollection');
		}
	}

	/**
	 * Adds a JOIN clause to the query using the RecruitmentUserData relation
	 *
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    RecruitmentUserQuery The current query, for fluid interface
	 */
	public function joinRecruitmentUserData($relationAlias = null, $joinType = Criteria::INNER_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('RecruitmentUserData');

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
			$this->addJoinObject($join, 'RecruitmentUserData');
		}

		return $this;
	}

	/**
	 * Use the RecruitmentUserData relation RecruitmentUserData object
	 *
	 * @see       useQuery()
	 *
	 * @param     string $relationAlias optional alias for the relation,
	 *                                   to be used as main alias in the secondary query
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    \Visualnet\VisualRecruiter\RecruitmentBundle\Model\RecruitmentUserDataQuery A secondary query class using the current class as primary query
	 */
	public function useRecruitmentUserDataQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
	{
		return $this
			->joinRecruitmentUserData($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'RecruitmentUserData', '\Visualnet\VisualRecruiter\RecruitmentBundle\Model\RecruitmentUserDataQuery');
	}

	/**
	 * Exclude object from result
	 *
	 * @param     RecruitmentUser $recruitmentUser Object to remove from the list of results
	 *
	 * @return    RecruitmentUserQuery The current query, for fluid interface
	 */
	public function prune($recruitmentUser = null)
	{
		if ($recruitmentUser) {
			$this->addUsingAlias(RecruitmentUserPeer::ID, $recruitmentUser->getId(), Criteria::NOT_EQUAL);
		}

		return $this;
	}

	// timestampable behavior
	
	/**
	 * Filter by the latest updated
	 *
	 * @param      int $nbDays Maximum age of the latest update in days
	 *
	 * @return     RecruitmentUserQuery The current query, for fluid interface
	 */
	public function recentlyUpdated($nbDays = 7)
	{
		return $this->addUsingAlias(RecruitmentUserPeer::UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
	}
	
	/**
	 * Filter by the latest created
	 *
	 * @param      int $nbDays Maximum age of in days
	 *
	 * @return     RecruitmentUserQuery The current query, for fluid interface
	 */
	public function recentlyCreated($nbDays = 7)
	{
		return $this->addUsingAlias(RecruitmentUserPeer::CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
	}
	
	/**
	 * Order by update date desc
	 *
	 * @return     RecruitmentUserQuery The current query, for fluid interface
	 */
	public function lastUpdatedFirst()
	{
		return $this->addDescendingOrderByColumn(RecruitmentUserPeer::UPDATED_AT);
	}
	
	/**
	 * Order by update date asc
	 *
	 * @return     RecruitmentUserQuery The current query, for fluid interface
	 */
	public function firstUpdatedFirst()
	{
		return $this->addAscendingOrderByColumn(RecruitmentUserPeer::UPDATED_AT);
	}
	
	/**
	 * Order by create date desc
	 *
	 * @return     RecruitmentUserQuery The current query, for fluid interface
	 */
	public function lastCreatedFirst()
	{
		return $this->addDescendingOrderByColumn(RecruitmentUserPeer::CREATED_AT);
	}
	
	/**
	 * Order by create date asc
	 *
	 * @return     RecruitmentUserQuery The current query, for fluid interface
	 */
	public function firstCreatedFirst()
	{
		return $this->addAscendingOrderByColumn(RecruitmentUserPeer::CREATED_AT);
	}

} // BaseRecruitmentUserQuery