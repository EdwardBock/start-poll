import {
	usePollButtonLabel,
	usePollOptions,
	usePollPost,
} from '../../../src/hooks/usePolls';
import { ProgressBar } from '@wordpress/components';

type Props = {
	pollId: number;
};
export default function PollPreview(props: Props) {
	const { pollId } = props;
	const { isLoading, post } = usePollPost(pollId);
	const [options] = usePollOptions(pollId);
	const [label] = usePollButtonLabel(pollId);

	if (isLoading) {
		return (
			<>
				<p>Umfrage wird geladen...</p>
				<ProgressBar className="start-poll__poll-progress-bar" />
			</>
		);
	}

	if(post == null){
		return (
			<p>Ungültige Umfrage ID {pollId}</p>
		)
	}

	const overall = options.reduce((value, item)=>value + Number(item.counter), 0)

	return (
		<div>
			<div data-title>{post?.title.rendered}</div>
			<div>
				<ul>
					{options.map((option, index) => {
						const percent = Math.round(((overall > 0) ? option.counter / overall : 0)*100);
						return (
							<li key={index}>
								<div>{option.label}</div>
								<div data-chart>
									<div data-bar style={{width: percent+"%" }}></div>
								</div>
							</li>
						);
					})}
				</ul>
			</div>
			<button disabled data-label>{label ? label : <i>Standard Label für Button</i>}</button>
		</div>
	);
}
