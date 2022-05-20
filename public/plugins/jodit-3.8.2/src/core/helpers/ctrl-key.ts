/*!
 * Jodit Editor (https://xdsoft.net/jodit/)
 * Released under MIT see LICENSE.txt in the project root for license information.
 * Copyright (c) 2013-2021 Valeriy Chupurnov. All rights reserved. https://xdsoft.net
 */

/**
 * CTRL pressed
 *
 * @param  {KeyboardEvent} e Event
 * @return {boolean} true ctrl key was pressed
 */
export const ctrlKey = (e: MouseEvent | KeyboardEvent): boolean => {
	if (
		typeof navigator !== 'undefined' &&
		navigator.userAgent.indexOf('Mac OS X') !== -1
	) {
		if (e.metaKey && !e.altKey) {
			return true;
		}
	} else if (e.ctrlKey && !e.altKey) {
		return true;
	}
	return false;
};