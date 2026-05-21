// src/components/Pagination.tsx
interface Props {
  current: number;
  last: number;
  onChange: (page: number) => void;
}

export default function Pagination({ current, last, onChange }: Props) {
  if (last <= 1) return null;
  return (
    <div className="pagination" style={{ justifyContent: 'flex-end', marginTop: 16 }}>
      <button className="page-btn" disabled={current === 1} onClick={() => onChange(current - 1)}>‹</button>
      {Array.from({ length: last }, (_, i) => i + 1).map(p => (
        <button key={p} className={`page-btn${p === current ? ' active' : ''}`} onClick={() => onChange(p)}>{p}</button>
      ))}
      <button className="page-btn" disabled={current === last} onClick={() => onChange(current + 1)}>›</button>
    </div>
  );
}
