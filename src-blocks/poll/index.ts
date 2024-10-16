import { registerBlockType } from '@wordpress/blocks';
import './style.scss';

// @ts-ignore
import metadata from './block.json';
import Edit from './edit';
import save from './save';

registerBlockType(metadata.name, {
	/**
	 * @see ./edit.tsx
	 */
	edit: Edit,
	/**
	 * @see ./save.tsx
	 */
	save: save,
});
