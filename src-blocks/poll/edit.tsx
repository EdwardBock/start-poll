import { useBlockProps } from '@wordpress/block-editor';
import { type BlockEditProps } from '@wordpress/blocks';
import SelectPoll from './components/SelectPoll';
import PollPreview from './components/PollPreview';

import './editor.scss';

export type Attributes = {
	pollId: number;
};

export default function Edit(props: BlockEditProps<Attributes>) {
	const { attributes, setAttributes } = props;

	return (
		<div
			{...useBlockProps({
				className: 'start-poll__poll',
			})}
		>
			{attributes.pollId <= 0 ? (
				<SelectPoll
					id={attributes.pollId}
					onChange={(id) => setAttributes({ pollId: id })}
				/>
			) : (
				<PollPreview pollId={attributes.pollId} />
			)}
		</div>
	);
}
