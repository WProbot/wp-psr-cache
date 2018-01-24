<?php
/**
 * Interface WpCacheKeyGen
 *
 * @package LeavesAndLove\WpPsrCache
 * @license GNU General Public License, version 2
 * @link    https://github.com/felixarntz/wp-psr-cache
 */

namespace LeavesAndLove\WpPsrCache\CacheKeyGen;

use InvalidArgumentException;

/**
 * WordPress cache key generator interface.
 *
 * @since 1.0.0
 */
interface WpCacheKeyGen
{

    /**
     * Generate the full cache key for a given key and group.
     *
     * @since 1.0.0
     *
     * @param string $key   A cache key.
     * @param string $group A cache group.
     * @return string The full cache key to use with cache implementations.
     */
    public function generate(string $key, string $group): string;

    /**
     * Add cache groups to consider global groups.
     *
     * @since 1.0.0
     *
     * @param array $groups The list of groups that are global.
     */
    public function addGlobalGroups(array $groups);

    /**
     * Add cache groups to consider network groups.
     *
     * @since 1.0.0
     *
     * @param array $groups The list of groups that are network-specific.
     */
    public function addNetworkGroups(array $groups);

    /**
     * Switch the site context.
     *
     * @since 1.0.0
     *
     * @param int $siteId Site ID to switch the context to.
     */
    public function switchSiteContext(int $siteId);

    /**
     * Switch the network context.
     *
     * @since 1.0.0
     *
     * @param int $networkId Network ID to switch the context to.
     */
    public function switchNetworkContext(int $networkId);
}
