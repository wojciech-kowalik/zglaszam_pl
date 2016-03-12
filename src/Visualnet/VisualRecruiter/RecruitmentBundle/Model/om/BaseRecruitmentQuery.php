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
use Visualnet\UserBundle\Model\Group;
use Visualnet\UserBundle\Model\User;
use Visualnet\VisualRecruiter\FormBundle\Model\Form;
use Visualnet\VisualRecruiter\RecruitmentBundle\Model\Recruitment;
use Visualnet\VisualRecruiter\RecruitmentBundle\Model\RecruitmentDate;
use Visualnet\VisualRecruiter\RecruitmentBundle\Model\RecruitmentPeer;
use Visualnet\VisualRecruiter\RecruitmentBundle\Model\RecruitmentQuery;
use Visualnet\VisualRecruiter\RecruitmentBundle\Model\RecruitmentUser;

/**
 * Base class that represents a query for the 'visual_recruitment' table.
 *
 * 
 *
 * @method     RecruitmentQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     RecruitmentQuery orderByFormId($order = Criteria::ASC) Order by the form_id column
 * @method     RecruitmentQuery orderByUserId($order = Criteria::ASC) Order by the user_id column
 * @method     RecruitmentQuery orderByGroupId($order = Criteria::ASC) Order by the group_id column
 * @method     RecruitmentQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method     RecruitmentQuery orderByAliasName($order = Criteria::ASC) Order by the alias_name column
 * @method     RecruitmentQuery orderByPlace($order = Criteria::ASC) Order by the place column
 * @method     RecruitmentQuery orderByIsActive($order = Criteria::ASC) Order by the is_active column
 * @method     RecruitmentQuery orderByDescription($order = Criteria::ASC) Order by the description column
 * @method     RecruitmentQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     RecruitmentQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method     RecruitmentQuery groupById() Group by the id column
 * @method     RecruitmentQuery groupByFormId() Group by the form_id column
 * @method     RecruitmentQuery groupByUserId() Group by the user_id column
 * @method     RecruitmentQuery groupByGroupId() Group by the group_id column
 * @method     RecruitmentQuery groupByName() Group by the name column
 * @method     RecruitmentQuery groupByAliasName() Group by the alias_name column
 * @method     RecruitmentQuery groupByPlace() Group by the place column
 * @method     RecruitmentQuery groupByIsActive() Group by the is_active column
 * @method     RecruitmentQuery groupByDescription() Group by the description column
 * @method     RecruitmentQuery groupByCreatedAt() Group by the created_at column
 * @method     RecruitmentQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method     RecruitmentQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     RecruitmentQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     RecruitmentQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     RecruitmentQuery leftJoinForm($relationAlias = null) Adds a LEFT JOIN clause to the query using the Form relation
 * @method     RecruitmentQuery rightJoinForm($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Form relation
 * @method     RecruitmentQuery innerJoinForm($relationAlias = null) Adds a INNER JOIN clause to the query using the Form relation
 *
 * @method     RecruitmentQuery leftJoinUser($relationAlias = null) Adds a LEFT JOIN clause to the query using the User relation
 * @method     RecruitmentQuery rightJoinUser($relationAlias = null) Adds a RIGHT JOIN clause to the query using the User relation
 * @method     RecruitmentQuery innerJoinUser($relationAlias = null) Adds a INNER JOIN clause to the query using the User relation
 *
 * @method     RecruitmentQuery leftJoinGroup($relationAlias = null) Adds a LEFT JOIN clause to the query using the Group relation
 * @method     RecruitmentQuery rightJoinGroup($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Group relation
 * @method     RecruitmentQuery innerJoinGroup($relationAlias = null) Adds a INNER JOIN clause to the query using the Group relation
 *
 * @method     RecruitmentQuery leftJoinRecruitmentDate($relationAlias = null) Adds a LEFT JOIN clause to the query using the RecruitmentDate relation
 * @method     RecruitmentQuery rightJoinRecruitmentDate($relationAlias = null) Adds a RIGHT JOIN clause to the query using the RecruitmentDate relation
 * @method     RecruitmentQuery innerJoinRecruitmentDate($relationAlias = null) Adds a INNER JOIN clause to the query using the RecruitmentDate relation
 *
 * @method     RecruitmentQuery leftJoinRecruitmentUser($relationAlias = null) Adds a LEFT JOIN clause to the query using the RecruitmentUser relation
 * @method     RecruitmentQuery rightJoinRecruitmentUser($relationAlias = null) Adds a RIGHT JOIN clause to the query using the RecruitmentUser relation
 * @method     RecruitmentQuery innerJoinRecruitmentUser($relationAlias = null) Adds a INNER JOIN clause to the query using the RecruitmentUser relation
 *
 * @method     Recruitment findOne(PropelPDO $con = null) Return the first Recruitment matching the query
 * @method     Recruitment findOneOrCreate(PropelPDO $con = null) Return the first Recruitment matching the query, or a new Recruitment object populated from the query conditions when no match is found
 *
 * @method     Recruitment findOneById(int $id) Return the first Recruitment filtered by the id column
 * @method     Recruitment findOneByFormId(int $form_id) Return the first Recruitment filtered by the form_id column
 * @method     Recruitment findOneByUserId(int $user_id) Return the first Recruitment filtered by the user_id column
 * @method     Recruitment findOneByGroupId(int $group_id) Return the first Recruitment filtered by the group_id column
 * @method     Recruitment findOneByName(string $name) Return the first Recruitment filtered by the name column
 * @method     Recruitment findOneByAliasName(string $alias_name) Return the first Recruitment filtered by the alias_name column
 * @method     Recruitment findOneByPlace(string $place) Return the first Recruitment filtered by the place column
 * @method     Recruitment findOneByIsActive(boolean $is_active) Return the first Recruitment filtered by the is_active column
 * @method     Recruitment findOneByDescription(string $description) Return the first Recruitment filtered by the description column
 * @method     Recruitment findOneByCreatedAt(string $created_at) Return the first Recruitment filtered by the created_at column
 * @method     Recruitment findOneByUpdatedAt(string $updated_at) Return the first Recruitment filtered by the updated_at column
 *
 * @method     array findById(int $id) Return Recruitment objects filtered by the id column
 * @method     array findByFormId(int $form_id) Return Recruitment objects filtered by the form_id column
 * @method     array findByUserId(int $user_id) Return Recruitment objects filtered by the user_id column
 * @method     array findByGroupId(int $group_id) Return Recruitment objects filtered by the group_id column
 * @method     array findByName(string $name) Return Recruitment objects filtered by the name column
 * @method     array findByAliasName(string $alias_name) Return Recruitment objects filtered by the alias_name column
 * @method     array findByPlace(string $place) Return Recruitment objects filtered by the place column
 * @method     array findByIsActive(boolean $is_active) Return Recruitment objects filtered by the is_active column
 * @method     array findByDescription(string $description) Return Recruitment objects filtered by the description column
 * @method     array findByCreatedAt(string $created_at) Return Recruitment objects filtered by the created_at column
 * @method     array findByUpdatedAt(string $updated_at) Return Recruitment objects filtered by the updated_at column
 *
 * @package    propel.generator.src.Visualnet.VisualRecruiter.RecruitmentBundle.Model.om
 */
abstract class BaseRecruitmentQuery extends ModelCriteria
{
	
	/**
	 * Initializes internal state of BaseRecruitmentQuery object.
	 *
	 * @param     string $dbName The dabase name
	 * @param     string $modelName The phpName of a model, e.g. 'Book'
	 * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
	 */
	public function __construct($dbName = 'default', $modelName = 'Visualnet\\VisualRecruiter\\RecruitmentBundle\\Model\\Recruitment', $modelAlias = null)
	{
		parent::__construct($dbName, $modelName, $modelAlias);
	}

	/**
	 * Returns a new RecruitmentQuery object.
	 *
	 * @param     string $modelAlias The alias of a model in the query
	 * @param     Criteria $criteria Optional Criteria to build the query from
	 *
	 * @return    RecruitmentQuery
	 */
	public static function create($modelAlias = null, $criteria = null)
	{
		if ($criteria instanceof RecruitmentQuery) {
			return $criteria;
		}
		$query = new RecruitmentQuery();
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
	 * @return    Recruitment|array|mixed the result, formatted by the current formatter
	 */
	public function findPk($key, $con = null)
	{
		if ($key === null) {
			return null;
		}
		if ((null !== ($obj = RecruitmentPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
			// the object is alredy in the instance pool
			return $obj;
		}
		if ($con === null) {
			$con = Propel::getConnection(RecruitmentPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
	 * @return    Recruitment A model object, or null if the key is not found
	 */
	protected function findPkSimple($key, $con)
	{
		$sql = 'SELECT `ID`, `FORM_ID`, `USER_ID`, `GROUP_ID`, `NAME`, `ALIAS_NAME`, `PLACE`, `IS_ACTIVE`, `DESCRIPTION`, `CREATED_AT`, `UPDATED_AT` FROM `visual_recruitment` WHERE `ID` = :p0';
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
			$obj = new Recruitment();
			$obj->hydrate($row);
			RecruitmentPeer::addInstanceToPool($obj, (string) $key);
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
	 * @return    Recruitment|array|mixed the result, formatted by the current formatter
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
	 * @return    RecruitmentQuery The current query, for fluid interface
	 */
	public function filterByPrimaryKey($key)
	{
		return $this->addUsingAlias(RecruitmentPeer::ID, $key, Criteria::EQUAL);
	}

	/**
	 * Filter the query by a list of primary keys
	 *
	 * @param     array $keys The list of primary key to use for the query
	 *
	 * @return    RecruitmentQuery The current query, for fluid interface
	 */
	public function filterByPrimaryKeys($keys)
	{
		return $this->addUsingAlias(RecruitmentPeer::ID, $keys, Criteria::IN);
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
	 * @return    RecruitmentQuery The current query, for fluid interface
	 */
	public function filterById($id = null, $comparison = null)
	{
		if (is_array($id) && null === $comparison) {
			$comparison = Criteria::IN;
		}
		return $this->addUsingAlias(RecruitmentPeer::ID, $id, $comparison);
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
	 * @return    RecruitmentQuery The current query, for fluid interface
	 */
	public function filterByFormId($formId = null, $comparison = null)
	{
		if (is_array($formId)) {
			$useMinMax = false;
			if (isset($formId['min'])) {
				$this->addUsingAlias(RecruitmentPeer::FORM_ID, $formId['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($formId['max'])) {
				$this->addUsingAlias(RecruitmentPeer::FORM_ID, $formId['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(RecruitmentPeer::FORM_ID, $formId, $comparison);
	}

	/**
	 * Filter the query on the user_id column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByUserId(1234); // WHERE user_id = 1234
	 * $query->filterByUserId(array(12, 34)); // WHERE user_id IN (12, 34)
	 * $query->filterByUserId(array('min' => 12)); // WHERE user_id > 12
	 * </code>
	 *
	 * @see       filterByUser()
	 *
	 * @param     mixed $userId The value to use as filter.
	 *              Use scalar values for equality.
	 *              Use array values for in_array() equivalent.
	 *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    RecruitmentQuery The current query, for fluid interface
	 */
	public function filterByUserId($userId = null, $comparison = null)
	{
		if (is_array($userId)) {
			$useMinMax = false;
			if (isset($userId['min'])) {
				$this->addUsingAlias(RecruitmentPeer::USER_ID, $userId['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($userId['max'])) {
				$this->addUsingAlias(RecruitmentPeer::USER_ID, $userId['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(RecruitmentPeer::USER_ID, $userId, $comparison);
	}

	/**
	 * Filter the query on the group_id column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByGroupId(1234); // WHERE group_id = 1234
	 * $query->filterByGroupId(array(12, 34)); // WHERE group_id IN (12, 34)
	 * $query->filterByGroupId(array('min' => 12)); // WHERE group_id > 12
	 * </code>
	 *
	 * @see       filterByGroup()
	 *
	 * @param     mixed $groupId The value to use as filter.
	 *              Use scalar values for equality.
	 *              Use array values for in_array() equivalent.
	 *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    RecruitmentQuery The current query, for fluid interface
	 */
	public function filterByGroupId($groupId = null, $comparison = null)
	{
		if (is_array($groupId)) {
			$useMinMax = false;
			if (isset($groupId['min'])) {
				$this->addUsingAlias(RecruitmentPeer::GROUP_ID, $groupId['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($groupId['max'])) {
				$this->addUsingAlias(RecruitmentPeer::GROUP_ID, $groupId['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(RecruitmentPeer::GROUP_ID, $groupId, $comparison);
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
	 * @return    RecruitmentQuery The current query, for fluid interface
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
		return $this->addUsingAlias(RecruitmentPeer::NAME, $name, $comparison);
	}

	/**
	 * Filter the query on the alias_name column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByAliasName('fooValue');   // WHERE alias_name = 'fooValue'
	 * $query->filterByAliasName('%fooValue%'); // WHERE alias_name LIKE '%fooValue%'
	 * </code>
	 *
	 * @param     string $aliasName The value to use as filter.
	 *              Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    RecruitmentQuery The current query, for fluid interface
	 */
	public function filterByAliasName($aliasName = null, $comparison = null)
	{
		if (null === $comparison) {
			if (is_array($aliasName)) {
				$comparison = Criteria::IN;
			} elseif (preg_match('/[\%\*]/', $aliasName)) {
				$aliasName = str_replace('*', '%', $aliasName);
				$comparison = Criteria::LIKE;
			}
		}
		return $this->addUsingAlias(RecruitmentPeer::ALIAS_NAME, $aliasName, $comparison);
	}

	/**
	 * Filter the query on the place column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByPlace('fooValue');   // WHERE place = 'fooValue'
	 * $query->filterByPlace('%fooValue%'); // WHERE place LIKE '%fooValue%'
	 * </code>
	 *
	 * @param     string $place The value to use as filter.
	 *              Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    RecruitmentQuery The current query, for fluid interface
	 */
	public function filterByPlace($place = null, $comparison = null)
	{
		if (null === $comparison) {
			if (is_array($place)) {
				$comparison = Criteria::IN;
			} elseif (preg_match('/[\%\*]/', $place)) {
				$place = str_replace('*', '%', $place);
				$comparison = Criteria::LIKE;
			}
		}
		return $this->addUsingAlias(RecruitmentPeer::PLACE, $place, $comparison);
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
	 * @return    RecruitmentQuery The current query, for fluid interface
	 */
	public function filterByIsActive($isActive = null, $comparison = null)
	{
		if (is_string($isActive)) {
			$is_active = in_array(strtolower($isActive), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
		}
		return $this->addUsingAlias(RecruitmentPeer::IS_ACTIVE, $isActive, $comparison);
	}

	/**
	 * Filter the query on the description column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByDescription('fooValue');   // WHERE description = 'fooValue'
	 * $query->filterByDescription('%fooValue%'); // WHERE description LIKE '%fooValue%'
	 * </code>
	 *
	 * @param     string $description The value to use as filter.
	 *              Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    RecruitmentQuery The current query, for fluid interface
	 */
	public function filterByDescription($description = null, $comparison = null)
	{
		if (null === $comparison) {
			if (is_array($description)) {
				$comparison = Criteria::IN;
			} elseif (preg_match('/[\%\*]/', $description)) {
				$description = str_replace('*', '%', $description);
				$comparison = Criteria::LIKE;
			}
		}
		return $this->addUsingAlias(RecruitmentPeer::DESCRIPTION, $description, $comparison);
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
	 * @return    RecruitmentQuery The current query, for fluid interface
	 */
	public function filterByCreatedAt($createdAt = null, $comparison = null)
	{
		if (is_array($createdAt)) {
			$useMinMax = false;
			if (isset($createdAt['min'])) {
				$this->addUsingAlias(RecruitmentPeer::CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($createdAt['max'])) {
				$this->addUsingAlias(RecruitmentPeer::CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(RecruitmentPeer::CREATED_AT, $createdAt, $comparison);
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
	 * @return    RecruitmentQuery The current query, for fluid interface
	 */
	public function filterByUpdatedAt($updatedAt = null, $comparison = null)
	{
		if (is_array($updatedAt)) {
			$useMinMax = false;
			if (isset($updatedAt['min'])) {
				$this->addUsingAlias(RecruitmentPeer::UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($updatedAt['max'])) {
				$this->addUsingAlias(RecruitmentPeer::UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(RecruitmentPeer::UPDATED_AT, $updatedAt, $comparison);
	}

	/**
	 * Filter the query by a related Form object
	 *
	 * @param     Form|PropelCollection $form The related object(s) to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    RecruitmentQuery The current query, for fluid interface
	 */
	public function filterByForm($form, $comparison = null)
	{
		if ($form instanceof Form) {
			return $this
				->addUsingAlias(RecruitmentPeer::FORM_ID, $form->getId(), $comparison);
		} elseif ($form instanceof PropelCollection) {
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
			return $this
				->addUsingAlias(RecruitmentPeer::FORM_ID, $form->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
	 * @return    RecruitmentQuery The current query, for fluid interface
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
	 * Filter the query by a related User object
	 *
	 * @param     User|PropelCollection $user The related object(s) to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    RecruitmentQuery The current query, for fluid interface
	 */
	public function filterByUser($user, $comparison = null)
	{
		if ($user instanceof User) {
			return $this
				->addUsingAlias(RecruitmentPeer::USER_ID, $user->getId(), $comparison);
		} elseif ($user instanceof PropelCollection) {
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
			return $this
				->addUsingAlias(RecruitmentPeer::USER_ID, $user->toKeyValue('PrimaryKey', 'Id'), $comparison);
		} else {
			throw new PropelException('filterByUser() only accepts arguments of type User or PropelCollection');
		}
	}

	/**
	 * Adds a JOIN clause to the query using the User relation
	 *
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    RecruitmentQuery The current query, for fluid interface
	 */
	public function joinUser($relationAlias = null, $joinType = Criteria::INNER_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('User');

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
			$this->addJoinObject($join, 'User');
		}

		return $this;
	}

	/**
	 * Use the User relation User object
	 *
	 * @see       useQuery()
	 *
	 * @param     string $relationAlias optional alias for the relation,
	 *                                   to be used as main alias in the secondary query
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    \Visualnet\UserBundle\Model\UserQuery A secondary query class using the current class as primary query
	 */
	public function useUserQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
	{
		return $this
			->joinUser($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'User', '\Visualnet\UserBundle\Model\UserQuery');
	}

	/**
	 * Filter the query by a related Group object
	 *
	 * @param     Group|PropelCollection $group The related object(s) to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    RecruitmentQuery The current query, for fluid interface
	 */
	public function filterByGroup($group, $comparison = null)
	{
		if ($group instanceof Group) {
			return $this
				->addUsingAlias(RecruitmentPeer::GROUP_ID, $group->getId(), $comparison);
		} elseif ($group instanceof PropelCollection) {
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
			return $this
				->addUsingAlias(RecruitmentPeer::GROUP_ID, $group->toKeyValue('PrimaryKey', 'Id'), $comparison);
		} else {
			throw new PropelException('filterByGroup() only accepts arguments of type Group or PropelCollection');
		}
	}

	/**
	 * Adds a JOIN clause to the query using the Group relation
	 *
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    RecruitmentQuery The current query, for fluid interface
	 */
	public function joinGroup($relationAlias = null, $joinType = Criteria::INNER_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('Group');

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
			$this->addJoinObject($join, 'Group');
		}

		return $this;
	}

	/**
	 * Use the Group relation Group object
	 *
	 * @see       useQuery()
	 *
	 * @param     string $relationAlias optional alias for the relation,
	 *                                   to be used as main alias in the secondary query
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    \Visualnet\UserBundle\Model\GroupQuery A secondary query class using the current class as primary query
	 */
	public function useGroupQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
	{
		return $this
			->joinGroup($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'Group', '\Visualnet\UserBundle\Model\GroupQuery');
	}

	/**
	 * Filter the query by a related RecruitmentDate object
	 *
	 * @param     RecruitmentDate $recruitmentDate  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    RecruitmentQuery The current query, for fluid interface
	 */
	public function filterByRecruitmentDate($recruitmentDate, $comparison = null)
	{
		if ($recruitmentDate instanceof RecruitmentDate) {
			return $this
				->addUsingAlias(RecruitmentPeer::ID, $recruitmentDate->getRecruitmentId(), $comparison);
		} elseif ($recruitmentDate instanceof PropelCollection) {
			return $this
				->useRecruitmentDateQuery()
				->filterByPrimaryKeys($recruitmentDate->getPrimaryKeys())
				->endUse();
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
	 * @return    RecruitmentQuery The current query, for fluid interface
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
	 * Filter the query by a related RecruitmentUser object
	 *
	 * @param     RecruitmentUser $recruitmentUser  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    RecruitmentQuery The current query, for fluid interface
	 */
	public function filterByRecruitmentUser($recruitmentUser, $comparison = null)
	{
		if ($recruitmentUser instanceof RecruitmentUser) {
			return $this
				->addUsingAlias(RecruitmentPeer::ID, $recruitmentUser->getRecruitmentId(), $comparison);
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
	 * @return    RecruitmentQuery The current query, for fluid interface
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
	 * @param     Recruitment $recruitment Object to remove from the list of results
	 *
	 * @return    RecruitmentQuery The current query, for fluid interface
	 */
	public function prune($recruitment = null)
	{
		if ($recruitment) {
			$this->addUsingAlias(RecruitmentPeer::ID, $recruitment->getId(), Criteria::NOT_EQUAL);
		}

		return $this;
	}

	// timestampable behavior
	
	/**
	 * Filter by the latest updated
	 *
	 * @param      int $nbDays Maximum age of the latest update in days
	 *
	 * @return     RecruitmentQuery The current query, for fluid interface
	 */
	public function recentlyUpdated($nbDays = 7)
	{
		return $this->addUsingAlias(RecruitmentPeer::UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
	}
	
	/**
	 * Filter by the latest created
	 *
	 * @param      int $nbDays Maximum age of in days
	 *
	 * @return     RecruitmentQuery The current query, for fluid interface
	 */
	public function recentlyCreated($nbDays = 7)
	{
		return $this->addUsingAlias(RecruitmentPeer::CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
	}
	
	/**
	 * Order by update date desc
	 *
	 * @return     RecruitmentQuery The current query, for fluid interface
	 */
	public function lastUpdatedFirst()
	{
		return $this->addDescendingOrderByColumn(RecruitmentPeer::UPDATED_AT);
	}
	
	/**
	 * Order by update date asc
	 *
	 * @return     RecruitmentQuery The current query, for fluid interface
	 */
	public function firstUpdatedFirst()
	{
		return $this->addAscendingOrderByColumn(RecruitmentPeer::UPDATED_AT);
	}
	
	/**
	 * Order by create date desc
	 *
	 * @return     RecruitmentQuery The current query, for fluid interface
	 */
	public function lastCreatedFirst()
	{
		return $this->addDescendingOrderByColumn(RecruitmentPeer::CREATED_AT);
	}
	
	/**
	 * Order by create date asc
	 *
	 * @return     RecruitmentQuery The current query, for fluid interface
	 */
	public function firstCreatedFirst()
	{
		return $this->addAscendingOrderByColumn(RecruitmentPeer::CREATED_AT);
	}

} // BaseRecruitmentQuery