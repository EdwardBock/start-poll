import { useEntityProp, useEntityRecord } from '@wordpress/core-data';

export const usePostMeta = (key: string, id?: number) => {
	const [meta, setMeta] = useEntityProp(
		'postType',
		window.StartPoll.post_type,
		'meta',
		id
	);

	return [meta?.[key], (value) => setMeta({ ...meta, [key]: value })];
};

export const usePollOptions = (pollId?: number) => {
	return usePostMeta(window.StartPoll.meta_keys.options, pollId) as [
		{ label: string; counter: number }[],
		(value: { label: string; counter: number }[]) => void,
	];
};

export const usePollButtonLabel = (pollId?: number) => {
	return usePostMeta(window.StartPoll.meta_keys.button_label, pollId) as [
		string,
		(value: string) => void,
	];
};

export const usePollPost = (pollId: number) => {
	const data = useEntityRecord(
		'postType',
		window.StartPoll.post_type,
		pollId
	);
	return {
		isLoading: data.isResolving,
		post: data.record as {
			title: {
				rendered: string;
			};
		} | null,
	};
};

declare global {
	interface Window {
		StartPoll: {
			post_type: string;
			meta_keys: {
				options: string;
				button_label: string;
			};
		};
	}
}
