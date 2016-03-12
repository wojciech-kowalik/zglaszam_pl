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
use Visualnet\VisualRecruiter\QuestionBundle\Model\Question;
use Visualnet\VisualRecruiter\RecruitmentBundle\Model\RecruitmentUser;
use Visualnet\VisualRecruiter\RecruitmentBundle\Model\RecruitmentUserData;
use Visualnet\VisualRecruiter\RecruitmentBundle\Model\RecruitmentUserDataPeer;
use Visualnet\VisualRecruiter\RecruitmentBundle\Model\RecruitmentUserDataQuery;

/**
 * Base class that represents a query for the 'visual_recruitment_user_data' table.
 *
 * 
 *
 * @method     RecruitmentUserDataQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     RecruitmentUserDataQuery orderByUserRecruitmentId($order = Criteria::ASC) Order by the user_recruitment_id column
 * @method     RecruitmentUserDataQuery orderByQuestionId($order = Criteria::ASC) Order by the question_id column
 * @method     RecruitmentUserDataQuery orderByValue($order = Criteria::ASC) Order by the value column
 *
 * @method     RecruitmentUserDataQuery groupById() Group by the id column
 * @method     RecruitmentUserDataQuery groupByUserRecruitmentId() Group by the user_recruitment_id column
 * @method     RecruitmentUserDataQuery groupByQuestionId() Group by the question_id column
 * @method     RecruitmentUserDataQuery groupByValue() Group by the value column
 *
 * @method     RecruitmentUserDataQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     RecruitmentUserDataQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     RecruitmentUserDataQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     RecruitmentUserDataQuery leftJoinRecruitmentUser($relationAlias = null) Adds a LEFT JOIN clause to the query using the RecruitmentUser relation
 * @method     RecruitmentUserDataQuery rightJoinRecruitmentUser($relationAlias = null) Adds a RIGHT JOIN clause to the query using the RecruitmentUser relation
 * @method     RecruitmentUserDataQuery innerJoinRecruitmentUser($relationAlias = null) Adds a INNER JOIN clause to the query using the RecruitmentUser relation
 *
 * @method     RecruitmentUserDataQuery leftJoinQuestion($relationAlias = null) Adds a LEFT JOIN clause to the query using the Question relation
 * @method     RecruitmentUserDataQuery rightJoinQuestion($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Question relation
 * @method     RecruitmentUserDataQuery innerJoinQuestion($relationAlias = null) Adds a INNER JOIN clause to the query using the Question relation
 *
 * @method     RecruitmentUserData findOne(PropelPDO $con = null) Return the first RecruitmentUserData matching the query
 * @method     RecruitmentUserData findOneOrCreate(PropelPDO $con = null) Return the first RecruitmentUserData matching the query, or a new RecruitmentUserData object populated from the query conditions when no match is found
 *
 * @method     RecruitmentUserData findOneById(int $id) Return the first RecruitmentUserData filtered by the id column
 * @method     RecruitmentUserData findOneByUserRecruitmentId(int $user_recruitment_id) Return the first RecruitmentUserData filtered by the user_recruitment_id column
 * @method     RecruitmentUserData findOneByQuestionId(int $question_id) Return the first RecruitmentUserData filtered by the question_id column
 * @method     RecruitmentUserData findOneByValue(string $value) Return the first RecruitmentUserData filtered by the value column
 *
 * @method     array findById(int $id) Return RecruitmentUserData objects filtered by the id column
 * @method     array findByUserRecruitmentId(int $user_recruitment_id) Return RecruitmentUserData objects filtered by the user_recruitment_id column
 * @method     array findByQuestionId(int $question_id) Return RecruitmentUserData objects filtered by the question_id column
 * @method     array findByValue(string $value) Return RecruitmentUserData objects filtered by the value column
 *
 * @package    propel.generator.src.Visualnet.VisualRecruiter.RecruitmentBundle.Model.om
 */
abstract class BaseRecruitmentUserDataQuery extends ModelCriteria
{
	
	/**
	 * Initializes internal state of BaseRecruitmentUserDataQuery object.
	 *
	 * @param     string $dbName The dabase name
	 * @param     string $modelName The phpName of a model, e.g. 'Book'
	 * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
	 */
	public function __construct($dbName = 'default', $modelName = 'Visualnet\\VisualRecruiter\\RecruitmentBundle\\Model\\RecruitmentUserData', $modelAlias = null)
	{
		parent::__construct($dbName, $modelName, $modelAlias);
	}

	/**
	 * Returns a new RecruitmentUserDataQuery object.
	 *
	 * @param     string $modelAlias The alias of a model in the query
	 * @param     Criteria $criteria Optional Criteria to build the query from
	 *
	 * @return    RecruitmentUserDataQuery
	 */
	public static function create($modelAlias = null, $criteria = null)
	{
		if ($criteria instanceof RecruitmentUserDataQuery) {
			return $criteria;
		}
		$query = new RecruitmentUserDataQuery();
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
	 * @return    RecruitmentUserData|array|mixed the result, formatted by the current formatter
	 */
	public function findPk($key, $con = null)
	{
		if ($key === null) {
			return null;
		}
		if ((null !== ($obj = RecruitmentUserDataPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
			// the object is alredy in the instance pool
			return $obj;
		}
		if ($con === null) {
			$con = Propel::getConnection(RecruitmentUserDataPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
	 * @return    RecruitmentUserData A model object, or null if the key is not found
	 */
	protected function findPkSimple($key, $con)
	{
		$sql = 'SELECT `ID`, `USER_RECRUITMENT_ID`, `QUESTION_ID`, `VALUE` FROM `visual_recruitment_user_data` WHERE `ID` = :p0';
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
			$obj = new RecruitmentUserData();
			$obj->hydrate($row);
			RecruitmentUserDataPeer::addInstanceToPool($obj, (string) $key);
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
	 * @return    RecruitmentUserData|array|mixed the result, formatted by the current formatter
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
	 * @return    RecruitmentUserDataQuery The current query, for fluid interface
	 */
	public function filterByPrimaryKey($key)
	{
		return $this->addUsingAlias(RecruitmentUserDataPeer::ID, $key, Criteria::EQUAL);
	}

	/**
	 * Filter the query by a list of primary keys
	 *
	 * @param     array $keys The list of primary key to use for the query
	 *
	 * @return    RecruitmentUserDataQuery The current query, for fluid interface
	 */
	public function filterByPrimaryKeys($keys)
	{
		return $this->addUsingAlias(RecruitmentUserDataPeer::ID, $keys, Criteria::IN);
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
	 * @return    RecruitmentUserDataQuery The current query, for fluid interface
	 */
	public function filterById($id = null, $comparison = null)
	{
		if (is_array($id) && null === $comparison) {
			$comparison = Criteria::IN;
		}
		return $this->addUsingAlias(RecruitmentUserDataPeer::ID, $id, $comparison);
	}

	/**
	 * Filter the query on the user_recruitment_id column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByUserRecruitmentId(1234); // WHERE user_recruitment_id = 1234
	 * $query->filterByUserRecruitmentId(array(12, 34)); // WHERE user_recruitment_id IN (12, 34)
	 * $query->filterByUserRecruitmentId(array('min' => 12)); // WHERE user_recruitment_id > 12
	 * </code>
	 *
	 * @see       filterByRecruitmentUser()
	 *
	 * @param     mixed $userRecruitmentId The value to use as filter.
	 *              Use scalar values for equality.
	 *              Use array values for in_array() equivalent.
	 *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    RecruitmentUserDataQuery The current query, for fluid interface
	 */
	public function filterByUserRecruitmentId($userRecruitmentId = null, $comparison = null)
	{
		if (is_array($userRecruitmentId)) {
			$useMinMax = false;
			if (isset($userRecruitmentId['min'])) {
				$this->addUsingAlias(RecruitmentUserDataPeer::USER_RECRUITMENT_ID, $userRecruitmentId['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($userRecruitmentId['max'])) {
				$this->addUsingAlias(RecruitmentUserDataPeer::USER_RECRUITMENT_ID, $userRecruitmentId['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(RecruitmentUserDataPeer::USER_RECRUITMENT_ID, $userRecruitmentId, $comparison);
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
	 * @return    RecruitmentUserDataQuery The current query, for fluid interface
	 */
	public function filterByQuestionId($questionId = null, $comparison = null)
	{
		if (is_array($questionId)) {
			$useMinMax = false;
			if (isset($questionId['min'])) {
				$this->addUsingAlias(RecruitmentUserDataPeer::QUESTION_ID, $questionId['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($questionId['max'])) {
				$this->addUsingAlias(RecruitmentUserDataPeer::QUESTION_ID, $questionId['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(RecruitmentUserDataPeer::QUESTION_ID, $questionId, $comparison);
	}

	/**
	 * Filter the query on the value column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByValue('fooValue');   // WHERE value = 'fooValue'
	 * $query->filterByValue('%fooValue%'); // WHERE value LIKE '%fooValue%'
	 * </code>
	 *
	 * @param     string $value The value to use as filter.
	 *              Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    RecruitmentUserDataQuery The current query, for fluid interface
	 */
	public function filterByValue($value = null, $comparison = null)
	{
		if (null === $comparison) {
			if (is_array($value)) {
				$comparison = Criteria::IN;
			} elseif (preg_match('/[\%\*]/', $value)) {
				$value = str_replace('*', '%', $value);
				$comparison = Criteria::LIKE;
			}
		}
		return $this->addUsingAlias(RecruitmentUserDataPeer::VALUE, $value, $comparison);
	}

	/**
	 * Filter the query by a related RecruitmentUser object
	 *
	 * @param     RecruitmentUser|PropelCollection $recruitmentUser The related object(s) to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    RecruitmentUserDataQuery The current query, for fluid interface
	 */
	public function filterByRecruitmentUser($recruitmentUser, $comparison = null)
	{
		if ($recruitmentUser instanceof RecruitmentUser) {
			return $this
				->addUsingAlias(RecruitmentUserDataPeer::USER_RECRUITMENT_ID, $recruitmentUser->getId(), $comparison);
		} elseif ($recruitmentUser instanceof PropelCollection) {
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
			return $this
				->addUsingAlias(RecruitmentUserDataPeer::USER_RECRUITMENT_ID, $recruitmentUser->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
	 * @return    RecruitmentUserDataQuery The current query, for fluid interface
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
	 * Filter the query by a related Question object
	 *
	 * @param     Question|PropelCollection $question The related object(s) to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    RecruitmentUserDataQuery The current query, for fluid interface
	 */
	public function filterByQuestion($question, $comparison = null)
	{
		if ($question instanceof Question) {
			return $this
				->addUsingAlias(RecruitmentUserDataPeer::QUESTION_ID, $question->getId(), $comparison);
		} elseif ($question instanceof PropelCollection) {
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
			return $this
				->addUsingAlias(RecruitmentUserDataPeer::QUESTION_ID, $question->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
	 * @return    RecruitmentUserDataQuery The current query, for fluid interface
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
	 * @param     RecruitmentUserData $recruitmentUserData Object to remove from the list of results
	 *
	 * @return    RecruitmentUserDataQuery The current query, for fluid interface
	 */
	public function prune($recruitmentUserData = null)
	{
		if ($recruitmentUserData) {
			$this->addUsingAlias(RecruitmentUserDataPeer::ID, $recruitmentUserData->getId(), Criteria::NOT_EQUAL);
		}

		return $this;
	}

} // BaseRecruitmentUserDataQuery