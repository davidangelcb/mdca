
import { parseWithAttributeSchema } from "@wordpress/blocks";

const domain = "walls.io";

/**
 * Parse user input and extract a wall identifier as best as possible.
 *
 * Returns the given user input if nothing can be matched.
 * Use this function if you want to make user input nice in realtime.
 *
 * @param {string} input
 * @return {string}
 */
export function parseInput(input) {
  if (typeof input !== "string") {
    return "";
  }

  // User is (hopefully) still typing...
  // There are no wall title_urls shorter than 2 characters
  if (input.length < 2) {
    return input;
  }

  return parseText(input) || input;
}

/**
 * Try to parse a wall identifier from the user input
 *
 * Returns null if nothing can be matched.
 * Use this function if you want to check if a string is representing a wall.
 *
 * @param {string} input
 * @return {string|null}
 */
export function parseText(input) {
  // Just another security layer against wrongly passed parameters
  if (typeof input !== "string") {
    return null;
  }

  input = input.trim();

  const minLength = `${domain}/ab`.length;

  if (input.length < minLength) {
    return null;
  }

  return parseUrl(input) || parseHtml(input);
}

/**
 * Try to parse a wall URL from the user input
 *
 * Returns null if nothing can be matched.
 *
 * Can match wall URLs with and without protocol, e.g.
 * - walls.io/mywall
 * - www.walls.io/mywall
 * - https://walls.io/mywall
 * - https://walls.io/mywall
 *
 * Returns null if the input doesn't contain "walls.io", e.g. only "mywall".
 *
 * @param {string} input
 * @return {string|null}
 */
export function parseUrl(input) {
  // Just another security layer against wrongly passed parameters
  if (typeof input !== "string") {
    return null;
  }

  input = input.trim();

  if (hasProtocol(input)) {
    const shortestPossibleLength = "http://walls.io/ab".length;
    if (input.length < shortestPossibleLength) {
      return null;
    }

    return parseWithProtocol(input);
  }

  const shortestPossibleLength = "walls.io/ab".length;
  if (input.length < shortestPossibleLength) {
    return null;
  }

  return parseWithoutProtocol(input);
}

/**
 * Replaces "www.domain" by "domain"
 *
 * @param {string} url
 * @return {string}
 */
export function stripWwwPart(url) {
  return url.replace("www." + domain, domain);
}

/**
 * Try to parse iframe and JavaScript embeds from a string
 *
 * @param {string} input
 * @return {string|null}
 */
export function parseHtml(input) {
  return parseIframe(input) || parseScriptTag(input);
}

/**
 * Check whether the input is an iframe embed code of a wall
 *
 * @param {string} input
 * @return {string|null}
 */
function parseIframe(input) {
  if (!startsWithIframe(input)) {
    return null;
  }

  const src = parseWithAttributeSchema(input, {
    source: "attribute",
    selector: "iframe[src]",
    attribute: "src",
  });

  return parseUrl(src);
}

function startsWithIframe(string) {
  return /^<iframe/.test(string);
}

/**
 * Check whether the input is an javascript embed code of a wall
 *
 * @param {string} input
 * @return {string|null}
 */
function parseScriptTag(input) {
  if (!startsWithScript(input)) {
    return null;
  }

  const src = parseWithAttributeSchema(input, {
    source: "attribute",
    selector: "script[data-wallurl][src^='https://walls.io']",
    attribute: "data-wallurl",
  });

  return parseUrl(src);
}

function startsWithScript(string) {
  return /^<script/.test(string);
}

/**
 * Try to parse a wall URL which doesn't start with a protocol
 *
 * Doesn't support IE11
 *
 * @param {string} url
 * @return {string|null}
 */
function parseWithoutProtocol(url) {
  const fullUrl = "https://" + url;
  return parseWithProtocol(fullUrl);
}

/**
 * Try to parse a wall URL
 *
 * The URL has to start with "http"/"https"
 * Doesn't support IE11
 *
 * @param {string} url
 * @return {string|null}
 */
function parseWithProtocol(url) {
  url = stripWwwPart(url);

  try {
    const parsedUrl = new URL(url, getBase());
    return checkParsedUrl(parsedUrl);
  } catch (e) {
    return null;
  }
}

function getBase() {
  return "https://" + domain;
}

/**
 * Checks if a URL object represents a valid wall URL
 *
 * @param {URL} parsedUrl
 * @return {string|null}
 */
export function checkParsedUrl(parsedUrl) {
  if (parsedUrl.hostname !== domain) {
    return null;
  }

  const firstPathPart = getFirstPathPart(parsedUrl.pathname);

  return isValidWallIdentifier(firstPathPart) ? firstPathPart : null;
}

/**
 * Check if a wall identifier is allowed
 *
 * Only checks syntax, not if the URL is used by walls.io
 *
 * @param {string} wallIdentifier
 * @return {boolean}
 */
function isValidWallIdentifier(wallIdentifier) {
  return /^[\w-]{2,126}$/.test(wallIdentifier);
}

/**
 * Return the first part of a path which is separated by '/'
 *
 * e.g.
 * - firstPathPart("hello/nice/world") => "hello"
 * - firstPathPart("hello") => "hello
 * - firstPathPart("") => ""
 *
 * @param {string} urlPath
 * @return {string}
 */
export function getFirstPathPart(urlPath) {
  const withoutTrailingSlash = removeTrailingSlash(urlPath);
  return withoutTrailingSlash.split("/").shift();
}

function removeTrailingSlash(path) {
  return path.replace(/^[/]/, "");
}

function hasProtocol(url) {
  const regex = new RegExp("^https?://");
  return regex.test(url);
}

/**
 * Parse a DOM node which may only contain a wall URL
 *
 * @param {HTMLElement} node
 * @return {string|null}
 */
export function parseDomNode(node) {
  if (!node || !node.textContent) {
    return null;
  }

  // Use `textContent` instead of innerText to not cause a reflow
  // https://developer.mozilla.org/en-US/docs/Web/API/Node/textContent#Differences_from_innerText
  const text = node.textContent;

  if (typeof text !== "string") {
    return null;
  }

  const textWithoutWhitespace = text.trim();

  return parseUrl(textWithoutWhitespace) || parseHtml(textWithoutWhitespace);
}
