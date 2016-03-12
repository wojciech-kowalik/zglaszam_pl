<?php

namespace Visualnet\VisualRecruiter\QuestionBundle\Model\om;

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
use Visualnet\VisualRecruiter\FormBundle\Model\FormQuestion;
use Visualnet\VisualRecruiter\QuestionBundle\Model\Question;
use Visualnet\VisualRecruiter\QuestionBundle\Model\QuestionPeer;
use Visualnet\VisualRecruiter\QuestionBundle\Model\QuestionQuery;
use Visualnet\VisualRecruiter\RecruitmentBundle\Model\RecruitmentUserData;

/**
 * Base class that represents a query for the 'visual_question' table.
 *
 * 
 *
 * @method     QuestionQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     QuestionQuery orderByUserId($order = Criteria::ASC) Order by the user_id column
 * @method     QuestionQuery orderByGroupId($order = Criteria::ASC) Order by the group_id column
 * @method     QuestionQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method     QuestionQuery orderByLabel($order = Criteria::ASC) Order by the label column
 * @method     QuestionQuery orderByType($order = Criteria::ASC) Order by the type column
 * @method     QuestionQuery orderByAnswers($order = Criteria::ASC) Order by the answers column
 * @method     QuestionQuery orderByLimit($order = Criteria::ASC) Order by the limit column
 * @method     QuestionQuery orderByValidationRulePredefined($order = Criteria::ASC) Order by the validation_rule_predefined column
 * @method     QuestionQuery orderByValidationRuleOptional($order = Criteria::ASC) Order by the validation_rule_optional column
 * @method     QuestionQuery orderByIsPredefined($order = Criteria::ASC) Order by the is_predefined column
 * @method     QuestionQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     QuestionQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 * @method     QuestionQuery orderBySortableRank($order = Criteria::ASC) Order by the sortable_rank column
 *
 * @method     QuestionQuery groupById() Group by the id column
 * @method     QuestionQuery groupByUserId() Group by the user_id column
 * @method     QuestionQuery groupByGroupId() Group by the group_id column
 * @method     QuestionQuery groupByName() Group by the name column
 * @method     QuestionQuery groupByLabel() Group by the label column
 * @method     QuestionQuery groupByType() Group by the type column
 * @method     QuestionQuery groupByAnswers() Group by the answers column
 * @method     QuestionQuery groupByLimit() Group by the limit column
 * @method     QuestionQuery groupByValidationRulePredefined() Group by the validation_rule_predefined column
 * @method     QuestionQuery groupByValidationRuleOptional() Group by the validation_rule_optional column
 * @method     QuestionQuery groupByIsPredefined() Group by the is_predefined column
 * @method     QuestionQuery groupByCreatedAt() Group by the created_at column
 * @method     QuestionQuery groupByUpdatedAt() Group by the updated_at column
 * @method     QuestionQuery groupBySortableRank() Group by the sortable_rank column
 *
 * @method     QuestionQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     QuestionQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     QuestionQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     QuestionQuery leftJoinUser($relationAlias = null) Adds a LEFT JOIN clause to the query using the User relation
 * @method     QuestionQuery rightJoinUser($relationAlias = null) Adds a RIGHT JOIN clause to the query using the User relation
 * @method     QuestionQuery innerJoinUser($relationAlias = null) Adds a INNER JOIN clause to the query using the User relation
 *
 * @method     QuestionQuery leftJoinGroup($relationAlias = null) Adds a LEFT JOIN clause to the query using the Group relation
 * @method     QuestionQuery rightJoinGroup($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Group relation
 * @method     QuestionQuery innerJoinGroup($relationAlias = null) Adds a INNER JOIN clause to the query using the Group relation
 *
 * @method     QuestionQuery leftJoinFormQuestion($relationAlias = null) Adds a LEFT JOIN clause to the query using the FormQuestion relation
 * @method     QuestionQuery rightJoinFormQuestion($relationAlias = null) Adds a RIGHT JOIN clause to the query using the FormQuestion relation
 * @method     QuestionQuery innerJoinFormQuestion($relationAlias = null) Adds a INNER JOIN clause to the query using the FormQuestion relation
 *
 * @method     QuestionQuery leftJoinRecruitmentUserData($relationAlias = null) Adds a LEFT JOIN clause to the query using the RecruitmentUserData relation
 * @method     QuestionQuery rightJoinRecruitmentUserData($relationAlias = null) Adds a RIGHT JOIN clause to the query using the RecruitmentUserData relation
 * @method     QuestionQuery innerJoinRecruitmentUserData($relationAlias = null) Adds a INNER JOIN clause to the query using the RecruitmentUserData relation
 *
 * @method     Question findOne(PropelPDO $con = null) Return the first Question matching the query
 * @method     Question findOneOrCreate(PropelPDO $con = null) Return the first Question matching the query, or a new Question object populated from the query conditions when no match is found
 *
 * @method     Question findOneById(int $id) Return the first Question filtered by the id column
 * @method     Question findOneByUserId(int $user_id) Return the first Question filtered by the user_id column
 * @method     Question findOneByGroupId(int $group_id) Return the first Question filtered by the group_id column
 * @method     Question findOneByName(string $name) Return the first Question filtered by the name column
 * @method     Question findOneByLabel(string $label) Return the first Question filtered by the label column
 * @method     Question findOneByType(int $type) Return the first Question filtered by the type column
 * @method     Question findOneByAnswers(string $answers) Return the first Question filtered by the answers column
 * @method     Question findOneByLimit(int $limit) Return the first Question filtered by the limit column
 * @method     Question findOneByValidationRulePredefined(string $validation_rule_predefined) Return the first Question filtered by the validation_rule_predefined column
 * @method     Question findOneByValidationRuleOptional(string $validation_rule_optional) Return the first Question filtered by the validation_rule_optional column
 * @method     Question findOneByIsPredefined(boolean $is_predefined) Return the first Question filtered by the is_predefined column
 * @method     Question findOneByCreatedAt(string $created_at) Return the first Question filtered by the created_at column
 * @method     Question findOneByUpdatedAt(string $updated_at) Return the first Question filtered by the updated_at column
 * @method     Question findOneBySortableRank(int $sortable_rank) Return the first Question filtered by the sortable_rank column
 *
 * @method     array findById(int $id) Return Question objects filtered by the id column
 * @method     array findByUserId(int $user_id) Return Question objects filtered by the user_id column
 * @method     array findByGroupId(int $group_id) Return Question objects filtered by the group_id column
 * @method     array findByName(string $name) Return Question objects filtered by the name column
 * @method     array findByLabel(string $label) Return Question objects filtered by the label column
 * @method     array findByType(int $type) Return Question objects filtered by the type column
 * @method     array findByAnswers(string $answers) Return Question objects filtered by the answers column
 * @method     array findByLimit(int $limit) Return Question objects filtered by the limit column
 * @method     array findByValidationRulePredefined(string $validation_rule_predefined) Return Question objects filtered by the validation_rule_predefined column
 * @method     array findByValidationRuleOptional(string $validation_rule_optional) Return Question objects filtered by the validation_rule_optional column
 * @method     array findByIsPredefined(boolean $is_predefined) Return Question objects filtered by the is_predefined column
 * @method     array findByCreatedAt(string $created_at) Return Question objects filtered by the created_at column
 * @method     array findByUpdatedAt(string $updated_at) Return Question objects filtered by the updated_at column
 * @method     array findBySortableRank(int $sortable_rank) Return Question objects filtered by the sortable_rank column
 *
 * @package    propel.generator.src.Visualnet.VisualRecruiter.QuestionBundle.Model.om
 */
abstract class BaseQuestionQuery extends ModelCriteria
{
	
	/**
	 * Initializes internal state of BaseQuestionQuery object.
	 *
	 * @param     string $dbName The dabase name
	 * @param     string $modelName The phpName of a model, e.g. 'Book'
	 * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
	 */
	public function __construct($dbName = 'default', $modelName = 'Visualnet\\VisualRecruiter\\QuestionBundle\\Model\\Question', $modelAlias = null)
	{
		parent::__construct($dbName, $modelName, $modelAlias);
	}

	/**
	 * Returns a new QuestionQuery object.
	 *
	 * @param     string $modelAlias The alias of a model in the query
	 * @param     Criteria $criteria Optional Criteria to build the query from
	 *
	 * @return    QuestionQuery
	 */
	public static function create($modelAlias = null, $criteria = null)
	{
		if ($criteria instanceof QuestionQuery) {
			return $criteria;
		}
		$query = new QuestionQuery();
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
	 * @return    Question|array|mixed the result, formatted by the current formatter
	 */
	public function findPk($key, $con = null)
	{
		if ($key === null) {
			return null;
		}
		if ((null !== ($obj = QuestionPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
			// the object is alredy in the instance pool
			return $obj;
		}
		if ($con === null) {
			$con = Propel::getConnection(QuestionPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
	 * @return    Question A model object, or null if the key is not found
	 */
	protected function findPkSimple($key, $con)
	{
		$sql = 'SELECT `ID`, `USER_ID`, `GROUP_ID`, `NAME`, `LABEL`, `TYPE`, `ANSWERS`, `LIMIT`, `VALIDATION_RULE_PREDEFINED`, `VALIDATION_RULE_OPTIONAL`, `IS_PREDEFINED`, `CREATED_AT`, `UPDATED_AT`, `SORTABLE_RANK` FROM `visual_question` WHERE `ID` = :p0';
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
			$obj = new Question();
			$obj->hydrate($row);
			QuestionPeer::addInstanceToPool($obj, (string) $key);
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
	 * @return    Question|array|mixed the result, formatted by the current formatter
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
	 * @return    QuestionQuery The current query, for fluid interface
	 */
	public function filterByPrimaryKey($key)
	{
		return $this->addUsingAlias(QuestionPeer::ID, $key, Criteria::EQUAL);
	}

	/**
	 * Filter the query by a list of primary keys
	 *
	 * @param     array $keys The list of primary key to use for the query
	 *
	 * @return    QuestionQuery The current query, for fluid interface
	 */
	public function filterByPrimaryKeys($keys)
	{
		return $this->addUsingAlias(QuestionPeer::ID, $keys, Criteria::IN);
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
	 * @return    QuestionQuery The current query, for fluid interface
	 */
	public function filterById($id = null, $comparison = null)
	{
		if (is_array($id) && null === $comparison) {
			$comparison = Criteria::IN;
		}
		return $this->addUsingAlias(QuestionPeer::ID, $id, $comparison);
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
	 * @return    QuestionQuery The current query, for fluid interface
	 */
	public function filterByUserId($userId = null, $comparison = null)
	{
		if (is_array($userId)) {
			$useMinMax = false;
			if (isset($userId['min'])) {
				$this->addUsingAlias(QuestionPeer::USER_ID, $userId['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($userId['max'])) {
				$this->addUsingAlias(QuestionPeer::USER_ID, $userId['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(QuestionPeer::USER_ID, $userId, $comparison);
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
	 * @return    QuestionQuery The current query, for fluid interface
	 */
	public function filterByGroupId($groupId = null, $comparison = null)
	{
		if (is_array($groupId)) {
			$useMinMax = false;
			if (isset($groupId['min'])) {
				$this->addUsingAlias(QuestionPeer::GROUP_ID, $groupId['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($groupId['max'])) {
				$this->addUsingAlias(QuestionPeer::GROUP_ID, $groupId['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(QuestionPeer::GROUP_ID, $groupId, $comparison);
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
	 * @return    QuestionQuery The current query, for fluid interface
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
		return $this->addUsingAlias(QuestionPeer::NAME, $name, $comparison);
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
	 * @return    QuestionQuery The current query, for fluid interface
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
		return $this->addUsingAlias(QuestionPeer::LABEL, $label, $comparison);
	}

	/**
	 * Filter the query on the type column
	 *
	 * @param     mixed $type The value to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    QuestionQuery The current query, for fluid interface
	 */
	public function filterByType($type = null, $comparison = null)
	{
		$valueSet = QuestionPeer::getValueSet(QuestionPeer::TYPE);
		if (is_scalar($type)) {
			if (!in_array($type, $valueSet)) {
				throw new PropelException(sprintf('Value "%s" is not accepted in this enumerated column', $type));
			}
			$type = array_search($type, $valueSet);
		} elseif (is_array($type)) {
			$convertedValues = array();
			foreach ($type as $value) {
				if (!in_array($value, $valueSet)) {
					throw new PropelException(sprintf('Value "%s" is not accepted in this enumerated column', $value));
				}
				$convertedValues []= array_search($value, $valueSet);
			}
			$type = $convertedValues;
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(QuestionPeer::TYPE, $type, $comparison);
	}

	/**
	 * Filter the query on the answers column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByAnswers('fooValue');   // WHERE answers = 'fooValue'
	 * $query->filterByAnswers('%fooValue%'); // WHERE answers LIKE '%fooValue%'
	 * </code>
	 *
	 * @param     string $answers The value to use as filter.
	 *              Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    QuestionQuery The current query, for fluid interface
	 */
	public function filterByAnswers($answers = null, $comparison = null)
	{
		if (null === $comparison) {
			if (is_array($answers)) {
				$comparison = Criteria::IN;
			} elseif (preg_match('/[\%\*]/', $answers)) {
				$answers = str_replace('*', '%', $answers);
				$comparison = Criteria::LIKE;
			}
		}
		return $this->addUsingAlias(QuestionPeer::ANSWERS, $answers, $comparison);
	}

	/**
	 * Filter the query on the limit column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByLimit(1234); // WHERE limit = 1234
	 * $query->filterByLimit(array(12, 34)); // WHERE limit IN (12, 34)
	 * $query->filterByLimit(array('min' => 12)); // WHERE limit > 12
	 * </code>
	 *
	 * @param     mixed $limit The value to use as filter.
	 *              Use scalar values for equality.
	 *              Use array values for in_array() equivalent.
	 *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    QuestionQuery The current query, for fluid interface
	 */
	public function filterByLimit($limit = null, $comparison = null)
	{
		if (is_array($limit)) {
			$useMinMax = false;
			if (isset($limit['min'])) {
				$this->addUsingAlias(QuestionPeer::LIMIT, $limit['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($limit['max'])) {
				$this->addUsingAlias(QuestionPeer::LIMIT, $limit['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(QuestionPeer::LIMIT, $limit, $comparison);
	}

	/**
	 * Filter the query on the validation_rule_predefined column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByValidationRulePredefined('fooValue');   // WHERE validation_rule_predefined = 'fooValue'
	 * $query->filterByValidationRulePredefined('%fooValue%'); // WHERE validation_rule_predefined LIKE '%fooValue%'
	 * </code>
	 *
	 * @param     string $validationRulePredefined The value to use as filter.
	 *              Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    QuestionQuery The current query, for fluid interface
	 */
	public function filterByValidationRulePredefined($validationRulePredefined = null, $comparison = null)
	{
		if (null === $comparison) {
			if (is_array($validationRulePredefined)) {
				$comparison = Criteria::IN;
			} elseif (preg_match('/[\%\*]/', $validationRulePredefined)) {
				$validationRulePredefined = str_replace('*', '%', $validationRulePredefined);
				$comparison = Criteria::LIKE;
			}
		}
		return $this->addUsingAlias(QuestionPeer::VALIDATION_RULE_PREDEFINED, $validationRulePredefined, $comparison);
	}

	/**
	 * Filter the query on the validation_rule_optional column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByValidationRuleOptional('fooValue');   // WHERE validation_rule_optional = 'fooValue'
	 * $query->filterByValidationRuleOptional('%fooValue%'); // WHERE validation_rule_optional LIKE '%fooValue%'
	 * </code>
	 *
	 * @param     string $validationRuleOptional The value to use as filter.
	 *              Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    QuestionQuery The current query, for fluid interface
	 */
	public function filterByValidationRuleOptional($validationRuleOptional = null, $comparison = null)
	{
		if (null === $comparison) {
			if (is_array($validationRuleOptional)) {
				$comparison = Criteria::IN;
			} elseif (preg_match('/[\%\*]/', $validationRuleOptional)) {
				$validationRuleOptional = str_replace('*', '%', $validationRuleOptional);
				$comparison = Criteria::LIKE;
			}
		}
		return $this->addUsingAlias(QuestionPeer::VALIDATION_RULE_OPTIONAL, $validationRuleOptional, $comparison);
	}

	/**
	 * Filter the query on the is_predefined column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByIsPredefined(true); // WHERE is_predefined = true
	 * $query->filterByIsPredefined('yes'); // WHERE is_predefined = true
	 * </code>
	 *
	 * @param     boolean|string $isPredefined The value to use as filter.
	 *              Non-boolean arguments are converted using the following rules:
	 *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
	 *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
	 *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    QuestionQuery The current query, for fluid interface
	 */
	public function filterByIsPredefined($isPredefined = null, $comparison = null)
	{
		if (is_string($isPredefined)) {
			$is_predefined = in_array(strtolower($isPredefined), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
		}
		return $this->addUsingAlias(QuestionPeer::IS_PREDEFINED, $isPredefined, $comparison);
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
	 * @return    QuestionQuery The current query, for fluid interface
	 */
	public function filterByCreatedAt($createdAt = null, $comparison = null)
	{
		if (is_array($createdAt)) {
			$useMinMax = false;
			if (isset($createdAt['min'])) {
				$this->addUsingAlias(QuestionPeer::CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($createdAt['max'])) {
				$this->addUsingAlias(QuestionPeer::CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(QuestionPeer::CREATED_AT, $createdAt, $comparison);
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
	 * @return    QuestionQuery The current query, for fluid interface
	 */
	public function filterByUpdatedAt($updatedAt = null, $comparison = null)
	{
		if (is_array($updatedAt)) {
			$useMinMax = false;
			if (isset($updatedAt['min'])) {
				$this->addUsingAlias(QuestionPeer::UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($updatedAt['max'])) {
				$this->addUsingAlias(QuestionPeer::UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(QuestionPeer::UPDATED_AT, $updatedAt, $comparison);
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
	 * @return    QuestionQuery The current query, for fluid interface
	 */
	public function filterBySortableRank($sortableRank = null, $comparison = null)
	{
		if (is_array($sortableRank)) {
			$useMinMax = false;
			if (isset($sortableRank['min'])) {
				$this->addUsingAlias(QuestionPeer::SORTABLE_RANK, $sortableRank['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($sortableRank['max'])) {
				$this->addUsingAlias(QuestionPeer::SORTABLE_RANK, $sortableRank['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(QuestionPeer::SORTABLE_RANK, $sortableRank, $comparison);
	}

	/**
	 * Filter the query by a related User object
	 *
	 * @param     User|PropelCollection $user The related object(s) to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    QuestionQuery The current query, for fluid interface
	 */
	public function filterByUser($user, $comparison = null)
	{
		if ($user instanceof User) {
			return $this
				->addUsingAlias(QuestionPeer::USER_ID, $user->getId(), $comparison);
		} elseif ($user instanceof PropelCollection) {
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
			return $this
				->addUsingAlias(QuestionPeer::USER_ID, $user->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
	 * @return    QuestionQuery The current query, for fluid interface
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
	 * @return    QuestionQuery The current query, for fluid interface
	 */
	public function filterByGroup($group, $comparison = null)
	{
		if ($group instanceof Group) {
			return $this
				->addUsingAlias(QuestionPeer::GROUP_ID, $group->getId(), $comparison);
		} elseif ($group instanceof PropelCollection) {
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
			return $this
				->addUsingAlias(QuestionPeer::GROUP_ID, $group->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
	 * @return    QuestionQuery The current query, for fluid interface
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
	 * Filter the query by a related FormQuestion object
	 *
	 * @param     FormQuestion $formQuestion  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    QuestionQuery The current query, for fluid interface
	 */
	public function filterByFormQuestion($formQuestion, $comparison = null)
	{
		if ($formQuestion instanceof FormQuestion) {
			return $this
				->addUsingAlias(QuestionPeer::ID, $formQuestion->getQuestionId(), $comparison);
		} elseif ($formQuestion instanceof PropelCollection) {
			return $this
				->useFormQuestionQuery()
				->filterByPrimaryKeys($formQuestion->getPrimaryKeys())
				->endUse();
		} else {
			throw new PropelException('filterByFormQuestion() only accepts arguments of type FormQuestion or PropelCollection');
		}
	}

	/**
	 * Adds a JOIN clause to the query using the FormQuestion relation
	 *
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    QuestionQuery The current query, for fluid interface
	 */
	public function joinFormQuestion($relationAlias = null, $joinType = Criteria::INNER_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('FormQuestion');

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
			$this->addJoinObject($join, 'FormQuestion');
		}

		return $this;
	}

	/**
	 * Use the FormQuestion relation FormQuestion object
	 *
	 * @see       useQuery()
	 *
	 * @param     string $relationAlias optional alias for the relation,
	 *                                   to be used as main alias in the secondary query
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    \Visualnet\VisualRecruiter\FormBundle\Model\FormQuestionQuery A secondary query class using the current class as primary query
	 */
	public function useFormQuestionQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
	{
		return $this
			->joinFormQuestion($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'FormQuestion', '\Visualnet\VisualRecruiter\FormBundle\Model\FormQuestionQuery');
	}

	/**
	 * Filter the query by a related RecruitmentUserData object
	 *
	 * @param     RecruitmentUserData $recruitmentUserData  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    QuestionQuery The current query, for fluid interface
	 */
	public function filterByRecruitmentUserData($recruitmentUserData, $comparison = null)
	{
		if ($recruitmentUserData instanceof RecruitmentUserData) {
			return $this
				->addUsingAlias(QuestionPeer::ID, $recruitmentUserData->getQuestionId(), $comparison);
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
	 * @return    QuestionQuery The current query, for fluid interface
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
	 * @param     Question $question Object to remove from the list of results
	 *
	 * @return    QuestionQuery The current query, for fluid interface
	 */
	public function prune($question = null)
	{
		if ($question) {
			$this->addUsingAlias(QuestionPeer::ID, $question->getId(), Criteria::NOT_EQUAL);
		}

		return $this;
	}

	// timestampable behavior
	
	/**
	 * Filter by the latest updated
	 *
	 * @param      int $nbDays Maximum age of the latest update in days
	 *
	 * @return     QuestionQuery The current query, for fluid interface
	 */
	public function recentlyUpdated($nbDays = 7)
	{
		return $this->addUsingAlias(QuestionPeer::UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
	}
	
	/**
	 * Filter by the latest created
	 *
	 * @param      int $nbDays Maximum age of in days
	 *
	 * @return     QuestionQuery The current query, for fluid interface
	 */
	public function recentlyCreated($nbDays = 7)
	{
		return $this->addUsingAlias(QuestionPeer::CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
	}
	
	/**
	 * Order by update date desc
	 *
	 * @return     QuestionQuery The current query, for fluid interface
	 */
	public function lastUpdatedFirst()
	{
		return $this->addDescendingOrderByColumn(QuestionPeer::UPDATED_AT);
	}
	
	/**
	 * Order by update date asc
	 *
	 * @return     QuestionQuery The current query, for fluid interface
	 */
	public function firstUpdatedFirst()
	{
		return $this->addAscendingOrderByColumn(QuestionPeer::UPDATED_AT);
	}
	
	/**
	 * Order by create date desc
	 *
	 * @return     QuestionQuery The current query, for fluid interface
	 */
	public function lastCreatedFirst()
	{
		return $this->addDescendingOrderByColumn(QuestionPeer::CREATED_AT);
	}
	
	/**
	 * Order by create date asc
	 *
	 * @return     QuestionQuery The current query, for fluid interface
	 */
	public function firstCreatedFirst()
	{
		return $this->addAscendingOrderByColumn(QuestionPeer::CREATED_AT);
	}

	// sortable behavior
	
	/**
	 * Filter the query based on a rank in the list
	 *
	 * @param     integer   $rank rank
	 *
	 * @return    QuestionQuery The current query, for fluid interface
	 */
	public function filterByRank($rank)
	{
		return $this
			->addUsingAlias(QuestionPeer::RANK_COL, $rank, Criteria::EQUAL);
	}
	
	/**
	 * Order the query based on the rank in the list.
	 * Using the default $order, returns the item with the lowest rank first
	 *
	 * @param     string $order either Criteria::ASC (default) or Criteria::DESC
	 *
	 * @return    QuestionQuery The current query, for fluid interface
	 */
	public function orderByRank($order = Criteria::ASC)
	{
		$order = strtoupper($order);
		switch ($order) {
			case Criteria::ASC:
				return $this->addAscendingOrderByColumn($this->getAliasedColName(QuestionPeer::RANK_COL));
				break;
			case Criteria::DESC:
				return $this->addDescendingOrderByColumn($this->getAliasedColName(QuestionPeer::RANK_COL));
				break;
			default:
				throw new PropelException('QuestionQuery::orderBy() only accepts "asc" or "desc" as argument');
		}
	}
	
	/**
	 * Get an item from the list based on its rank
	 *
	 * @param     integer   $rank rank
	 * @param     PropelPDO $con optional connection
	 *
	 * @return    Question
	 */
	public function findOneByRank($rank, PropelPDO $con = null)
	{
		return $this
			->filterByRank($rank)
			->findOne($con);
	}
	
	/**
	 * Returns the list of objects
	 *
	 * @param      PropelPDO $con	Connection to use.
	 *
	 * @return     mixed the list of results, formatted by the current formatter
	 */
	public function findList($con = null)
	{
		return $this
			->orderByRank()
			->find($con);
	}
	
	/**
	 * Get the highest rank
	 * 
	 * @param     PropelPDO optional connection
	 *
	 * @return    integer highest position
	 */
	public function getMaxRank(PropelPDO $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(QuestionPeer::DATABASE_NAME);
		}
		// shift the objects with a position lower than the one of object
		$this->addSelectColumn('MAX(' . QuestionPeer::RANK_COL . ')');
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
			$con = Propel::getConnection(QuestionPeer::DATABASE_NAME);
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

} // BaseQuestionQuery